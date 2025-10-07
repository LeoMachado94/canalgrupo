<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $users = $this->repository->get();
        return DataTables::of($users)->make(true);
    }

    public function lists()
    {
        return $this->repository->all(['id', 'name']);
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json([
               'success' => true,
               'title' => 'Removido!',
               'message' => 'Usuário removido com sucesso!',
               'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'title' => 'Erro ao remover usuário.',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
}
