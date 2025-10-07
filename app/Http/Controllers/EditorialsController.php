<?php

namespace App\Http\Controllers;

use App\Repositories\EditorialRepository;
use App\Validators\EditorialValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class EditorialsController extends Controller
{
    protected $repository;
    protected $validator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EditorialRepository $repository, EditorialValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Show the application editorials list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('editorials.index');
    }

    /**
     * Show the application editorials create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('editorials.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $vehicle = $this->repository->create($data);

            return redirect()->route('editorials.index')->with([
                'success' => true,
                'title' => 'Cadastrado!',
                'message' => 'Editorial/Programa cadastrado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

    public function show($id)
    {
        $editorial = $this->repository->find($id);
        return view('editorials.show', compact('editorial'));
    }

    public function edit($id)
    {
        $editorial = $this->repository->find($id);
        return view('editorials.edit', compact('editorial'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $editorial = $this->repository->update($data, $id);

            return redirect()->route('editorials.index')->with([
                'success' => true,
                'title' => 'Atualizado!',
                'message' => 'Editorial/Programa atualizado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }
}
