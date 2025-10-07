<?php

namespace App\Http\Controllers;

use App\Models\SubjectMatter;
use App\Repositories\SubjectMatterRepository;
use App\Rules\UniqueSubjectRule;
use App\Validators\SubjectMatterValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

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

    /**
     * Show the application subjects list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('subjects.index');
    }

    /**
     * Show the application subjects create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $this->validate($request, ['title' => new UniqueSubjectRule()]);

            if (!empty($subjectNew)) {
                return back()->withInput()->with([
                    'success' => true,
                    'title' => 'Assunto Já Existe!',
                    'message' => 'Já existe um assunto com este título!',
                    'icon' => 'warning'
                ]);
            }

            $subject = $this->repository->create($data);

            return redirect()->route('subjects.index')->with([
                'success' => true,
                'title' => 'Cadastrado!',
                'message' => 'Assunto cadastrado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return back()->withInput()->withErrors($e->getMessageBag());
        }
    }

    public function show($id)
    {
        $subject = $this->repository->find($id);
        return view('subjects.show', compact('subject'));
    }

    public function edit($id)
    {
        $subject = $this->repository->find($id);
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $subject = $this->repository->update($data, $id);

            return redirect()->route('subjects.index')->with([
                'success' => true,
                'title' => 'Atualizado!',
                'message' => 'Assunto atualizado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }
}
