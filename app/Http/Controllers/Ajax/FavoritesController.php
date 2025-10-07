<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Mail\FavoritesReportMail;
use App\Models\Client;
use App\Models\Clipping;
use App\Repositories\ClippingRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class FavoritesController extends Controller
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

                if (empty($request->query('start_date')) && empty($request->query('end_date'))) {
                    $date = Carbon::today()->format('Y-m-d');
                    $builder->whereBetween('date', [$date, $date]);
                }

                return $builder;
            })->where('is_favorite', 1)->orderBy('date', 'desc')->limit(3000);

        $clippings = Auth::guard('client')->user() ?
            $clippings->where('client_id', Auth::guard('client')->user()->id) :
            $clippings->get();
        return DataTables::of($clippings)->make(true);
    }

    public function sendMail(Request $request)
    {
        try {
            $client = Client::findOrFail($request->input('client_id'));

            $clippings = Clipping::with(['client', 'exhibition', 'subject', 'middle', 'classification', 'user'])
                ->where(function (Builder $builder) use ($request) {
                    // Client
                    if (!empty($request->input('client_id'))) {
                        $builder->where('client_id', $request->input('client_id'));
                    }
                    // Exhibition
                    if (!empty($request->input('exhibition_id'))) {
                        $builder->where('exhibition_id', $request->input('exhibition_id'));
                    }

                    // Middle
                    if (!empty($request->input('middle_id'))) {
                        $builder->where('middle_id', $request->input('middle_id'));
                    }

                    // Classification
                    if (!empty($request->input('classification_id'))) {
                        $builder->where('classification_id', $request->input('classification_id'));
                    }

                    // Start Date (veiculação)
                    if (!empty($request->input('start_date'))) {
                        $startDate = Carbon::createFromFormat('d/m/Y', $request->input('start_date'));
                        $builder->where('date', '>=', $startDate->format('Y-m-d'));
                    }

                    // End Date (veiculação)
                    if (!empty($request->input('end_date'))) {
                        $endDate = Carbon::createFromFormat('d/m/Y', $request->input('end_date'));
                        $builder->where('date', '<=', $endDate->format('Y-m-d'));
                    }

                    if (empty($request->input('start_date')) && empty($request->input('end_date'))) {
                        $date = Carbon::today()->format('Y-m-d');
                        $builder->whereBetween('date', [$date, $date]);
                    }

                    $builder->where('is_favorite', true);
                    $builder->whereIn('id', explode(',', $request->input('clippings')));

                    return $builder;
                })->orderBy('date', 'desc')->limit(3000)->get();

            $emails = $client->emails->pluck('email')->toArray();
            if (empty($emails) && empty($client->email)) {
                return response()->json([
                    'success' => true,
                    'title' => 'Nenhum email cadastrado!',
                    'message' => 'O cliente não possui um email cadastrado para receber o relatório!',
                    'icon' => 'warning',
                ]);
            }
            if (empty($emails)) {
                Mail::to($client->email)->send(new FavoritesReportMail(
                    $client,
                    $clippings
                ));
            } else {
                Mail::to($client->email)->cc($emails)->send(new FavoritesReportMail(
                    $client,
                    $clippings
                ));
            }

            return response()->json([
                'success' => true,
                'title' => 'Emails Enviados!',
                'message' => 'Emails enviados com sucesso!',
                'icon' => 'success',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'title' => 'Cliente Não Encontrado!',
                'message' => 'Cliente Não Encontrado!',
                'icon' => 'error'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Erro ao Enviar Email!',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ], 400);
        }
    }
}
