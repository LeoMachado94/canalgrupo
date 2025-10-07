<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Clipping;
use App\Repositories\ClientRepository;
use App\Repositories\ClippingRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ClippingsController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClippingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        Clipping::$skipMutators = ['date', 'created'];
        $clippings = Clipping::with(['client', 'exhibition', 'subject', 'middle', 'classification', 'user'])
                    ->where(function (Builder $builder) use ($request) {
            // Client
            if (!empty($request->query('client_id'))) {
                $builder->where('client_id', $request->query('client_id'));
            }
            // Exhibition
            if (!empty($request->query('exhibition_id'))) {
                $builder->where('exhibition_id', $request->query('exhibition_id'));
            }

            // Middle
            if (!empty($request->query('middle_id'))) {
                $builder->where('middle_id', $request->query('middle_id'));
            }

            // Classification
            if (!empty($request->query('classification_id'))) {
                $builder->where('classification_id', $request->query('classification_id'));
            }

            // Source
            if (!empty($request->query('source_id'))) {
                $builder->where('source_id', $request->query('source_id'));
            }

            // Vehicle
            if (!empty($request->query('vehicle_id'))) {
                $builder->where('vehicle_id', $request->query('vehicle_id'));
            }

            // User
            if (!empty($request->query('user_id'))) {
                $builder->where('user_id', $request->query('user_id'));
            }

            // Start Date (veiculação)
            if (!empty($request->query('start_date'))) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->query('start_date'));
                $builder->where('date', '>=', $startDate->format('Y-m-d'));
            }

            // End Date (veiculação)
            if (!empty($request->query('end_date'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->query('end_date'));
                $builder->where('date', '<=', $endDate->format('Y-m-d'));
            }

            if (!empty($request->query('title'))) {
                $title = request()->query('title');
                $builder->where(function ($builder2) use ($title) {
                    $builder2->orWhereHas('subject', function($builder3) use ($title) {
                        $builder3->where('title', 'like', "%{$title}%");
                    });
                    $builder2->orWhere('title', 'like', "%{$title}%");
                });
            }

            return $builder;
        })->orderBy('date', 'desc')->limit(3000);

        $clippings = Auth::guard('client')->user() ?
                    $clippings->where('client_id', Auth::guard('client')->user()->id) :
                    $clippings->get();
        return DataTables::of($clippings)->make(true);
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json([
               'success' => true,
               'title' => 'Removido!',
               'message' => 'Clipping removido com sucesso!',
               'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Erro ao remover clipping.',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
}
