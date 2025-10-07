<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use Yajra\DataTables\DataTables;

class VehiclesController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(VehicleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $vehicles = $this->repository->with(['state', 'city', 'middle']);
        return DataTables::of($vehicles->get())->make(true);
    }

    public function lists()
    {
        if (request()->query('middle')) {
            return Vehicle::where('middle_id', request()->query('middle'))->where('active', 1)
                    ->get(['id', 'name']);
        }
        return Vehicle::where('active', 1)->get(['id', 'name']);
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json([
               'success' => true,
               'title' => 'Removido!',
               'message' => 'Veículo removido com sucesso!',
               'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'title' => 'Erro ao remover veículo.',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
}
