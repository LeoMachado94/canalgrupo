<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\SubjectMatter;
use App\Repositories\SubjectMatterRepository;
use App\Rules\UniqueSubjectRule;
use App\Validators\SubjectMatterValidator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Yajra\DataTables\DataTables;

class SubjectsController extends Controller
{
    protected $repository;
    protected $validator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubjectMatterRepository $repository, SubjectMatterValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index()
    {
        dd(!empty(request()->query('title')));
        $subjects = SubjectMatter::with(['client', 'user'])->where(function(Builder $builder) {
            if (!empty(request()->query('title'))) {
                $title = request()->query('title');
                $builder->where('title', 'like', "%{$title}%");
            }
            if (!empty(request()->query('client_id'))) {
                $builder->where('client_id', request()->query('client_id'));
            }
            $builder->where('active', 1);
            return $builder;
        })->orderBy('created_at', 'desc')->limit(2000);

        return DataTables::of($subjects->get())->make(true);
    }

    public function lists()
    {
        if (!request()->query('client_id') || empty(request()->query('client_id'))) {
            return response()->json([]);
        }
        $subjects = SubjectMatter::where(function(Builder $builder) {
            $search = request()->query('search');
            $builder->where('client_id', request()->query('client_id'));
            $builder->where('title', 'like', "%{$search}%");
            $builder->where('active', 1);
        })->get(['id', 'title', 'client_id']);

        return $subjects;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $this->validate($request, ['title' => new UniqueSubjectRule()]);

            $subject = $this->repository->create($data);

            return response()->json([
                'success' => true,
                'title' => 'Cadastrado!',
                'message' => 'Assunto cadastrado com sucesso',
                'icon' => 'success',
                'subject' => $subject
            ]);
        } catch (ValidatorException $e) {
            return response()->json([
                'success' => false,
                'title' => 'Erro ao cadastrar!',
                'message' => $e->getMessageBag()->first(),
                'icon' => 'error'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json([
               'success' => true,
               'title' => 'Removido!',
               'message' => 'Assunto removido com sucesso!',
               'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'title' => 'Erro ao remover assunto.',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
}
