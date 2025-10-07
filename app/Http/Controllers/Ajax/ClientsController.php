<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\ClientRepository;
use Yajra\DataTables\DataTables;

class ClientsController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $clients = $this->repository->with('phones');
        return DataTables::of($clients->get())->make(true);
    }

    public function lists()
    {
        return $this->repository->findWhere(['active' => 1]);
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json([
               'success' => true,
               'title' => 'Removido!',
               'message' => 'Cliente removido com sucesso!',
               'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'title' => 'Erro ao remover cliente.',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
}
