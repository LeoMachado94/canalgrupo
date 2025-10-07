<?php

namespace App\Http\Controllers;

use App\Repositories\SummaryRepository;
use App\Validators\SummaryValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class SummariesController extends Controller
{
    protected $repository;
    protected $validator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SummaryRepository $repository, SummaryValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Show the application summaries list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('summaries.index');
    }

    /**
     * Show the application summaries create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('summaries.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $summary = $this->repository->create($data);

            // Upload Profile img
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = uniqid().'.'.$file->getClientOriginalExtension();
                $path = 'assets/files/summaries';
                $file->move(public_path($path), $fileName);

                $summary->file = $path.'/'.$fileName;
                $summary->save();
            }

            return redirect()->route('summaries.index')->with([
                'success' => true,
                'title' => 'Cadastrado!',
                'message' => 'Resumo cadastrado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

    public function show($id)
    {
        $summary = $this->repository->find($id);
        return view('summaries.show', compact('summary'));
    }

    public function edit($id)
    {
        $summary = $this->repository->find($id);
        return view('summaries.edit', compact('summary'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $summary = $this->repository->update($data, $id);

            // Upload Profile img
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = uniqid().'.'.$file->getClientOriginalExtension();
                $path = 'assets/files/summaries';
                $file->move(public_path($path), $fileName);

                $summary->file = $path.'/'.$fileName;
                $summary->save();
            }

            return redirect()->route('summaries.index')->with([
                'success' => true,
                'title' => 'Atualizado!',
                'message' => 'Resumo atualizado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }
}
