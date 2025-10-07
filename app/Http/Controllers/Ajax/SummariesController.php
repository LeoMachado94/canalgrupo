<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\SummaryRepository;
use Yajra\DataTables\DataTables;

class SummariesController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SummaryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $summaries = $this->repository->with(['client']);
        return DataTables::of($summaries->get())->make(true);
    }

    public function destroy($id)
    {
        try {
            $summary = $this->repository->find($id);
            if (file_exists(public_path($summary->file))) {
                unlink(public_path($summary->file));
            }
            $summary->delete();

            return response()->json([
               'success' => true,
               'title' => 'Removido!',
               'message' => 'Resumo removido com sucesso!',
               'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'title' => 'Erro ao remover resumo.',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
}
