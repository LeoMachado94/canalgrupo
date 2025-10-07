<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class UsersController extends Controller
{
    protected $repository;
    protected $validator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Show the application users list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the application users create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = array_filter($request->all());
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            // Handle file Upload
            if ($request->hasFile('avatar')) {
                $fileName = 'avatar_' . time();
                $path = $this->uploadFile($request, 'avatar', "users/avatars", $fileName);
                $data['avatar'] = $path;
            }
            $user = $this->repository->create($data);

            return redirect()->route('users.index')->with([
                'success' => true,
                'title' => 'Cadastrado!',
                'message' => 'Usuário cadastrado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

    public function show($id)
    {
        $user = $this->repository->find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->repository->find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = array_filter($request->all());
        try {
            $user = $this->repository->find($id);
            $this->validator->setId($id)->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            // Handle file Upload
            if ($request->hasFile('avatar')) {
                $fileName = 'avatar_' . time();
                $path = $this->uploadFile($request, 'avatar', "users/avatars", $fileName, $user->avatar);
                $data['avatar'] = $path;
            }

            $user = $this->repository->update($data, $id);

            return redirect()->route('users.index')->with([
                'success' => true,
                'title' => 'Atualizado!',
                'message' => 'Usuário atualizado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }
}
