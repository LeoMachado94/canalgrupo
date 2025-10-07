<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Clipping;
use App\Models\Middle;
use App\Repositories\ClippingRepository;
use App\Validators\ClippingValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class ClippingsController extends Controller
{
    protected $repository;

    protected $validator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClippingRepository $repository, ClippingValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Show the application clippings list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $queryString = str_replace($request->url(), '',$request->fullUrl());
        return view('clippings.index', compact('queryString'));
    }

    /**
     * Show the application clippings create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('clippings.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $clipping = $this->repository->create($data);

            return redirect()->route('clippings.edit', [$clipping->id, 'action' => 'create']);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

    public function edit($id)
    {
        $clipping = $this->repository->find($id);
        return view('clippings.edit', compact('clipping'));
    }

    public function show($id)
    {
        $clipping = $this->repository->find($id);
        return view('clippings.show', compact('clipping'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);


			if ($request->get('action') === 'create') {
				// Save without trigger event
				$clipping = $this->repository->find($id);
				$clipping->fill($data);
				$clipping->saveWithoutEvents();

				$title = "Cadastrado!";
				$message = "Clipping cadastrado com sucesso";
			} else {
				$clipping = $this->repository->update($data, $id);

				$title = "Atualizado!";
				$message = "Clipping atualizado com sucesso";
			}

            return redirect()->route('clippings.index')->with([
                'success' => true,
                'title' => $title,
                'message' => $message,
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }
}
