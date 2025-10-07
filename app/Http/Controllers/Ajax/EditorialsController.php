<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\EditorialRepository;
use Yajra\DataTables\DataTables;

class EditorialsController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EditorialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $editorials = $this->repository->with(['vehicle']);
        return DataTables::of($editorials->get())->make(true);
    }

    public function lists()
    {
        if (!request()->query('vehicle') || empty(request()->query('vehicle'))) {
            return response()->json([]);
        }
        return $this->repository->where('vehicle_id', request()
            ->query('vehicle'))->where('active', 1)
            ->get(['id', 'title']);
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json([
               'success' => true,
               'title' => 'Removido!',
               'message' => 'Editorial/Programa removido com sucesso!',
               'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'title' => 'Erro ao remover editorial/programa.',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
}
