<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Validators\ClientValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientsController extends Controller
{
    protected $repository;
    protected $validator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClientRepository $repository, ClientValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Show the application clients list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('clients.index');
    }

    /**
     * Show the application clients create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $data = array_filter($request->except('logo'));
        $data['active'] = 1;
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            $client = $this->repository->create($data);

            // Phones
            if ($client && !empty($data['phones'])) {
                $phones = collect();
                foreach ($data['phones'] as $phone) {
                    empty($phone) ?: $phones->push($phone);
                }
                /**
                 * @var Client $client
                 */
                $phones->each(function($phone) use ($client) {
                    $client->phones()->create(
                        ['phone_number' => str_replace(['(', ')', ' '], '', $phone)]
                    );
                });
            }

            // Emails
            if ($client && !empty($data['emails'])) {
                $emails = collect();
                foreach ($data['emails'] as $email) {
                    if (!empty($email) && $this->validateEmail(['email' => $email])) {
                        $emails->push($email);
                    }
                }
                /**
                 * @var Client $client
                 */
                $emails->each(function($email) use ($client) {
                    $client->emails()->create(
                        ['email' => str_replace(['(', ')', ' '], '', $email)]
                    );
                });
            }

            // Upload Profile img
            if($request->hasFile('logo')) {
                $fileName = 'avatar_' . time();
                $path = $this->uploadFile($request, 'logo', "clients/avatars", $fileName, $client->logo);
                $client->logo = $path;
                $client->save();
            }
            return redirect()->route('clients.index')->with([
                'success' => true,
                'title' => 'Cadastrado!',
                'message' => 'Cliente cadastrado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

    public function show($id)
    {
        $client = $this->repository->find($id);
        return view('clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = $this->repository->find($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $data = array_filter($request->except('logo'));
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            $client = $this->repository->update($data, $id);

            // Phones
            if ($client && !empty($data['phones'])) {
                $phones = collect();
                foreach ($data['phones'] as $phone) {
                    empty($phone) ?: $phones->push($phone);
                }
                /**
                 * @var Client $client
                 */
                $client->phones()->delete();
                $phones->each(function($phone) use ($client) {
                    $client->phones()->create(
                        ['phone_number' => str_replace(['(', ')', ' '], '', $phone)]
                    );
                });
            }

            // Emails
            if ($client && !empty($data['emails'])) {
                $emails = collect();
                foreach ($data['emails'] as $email) {
                    if (!empty($email) && $this->validateEmail(['email' => $email])) {
                        $emails->push($email);
                    }
                }
                /**
                 * @var Client $client
                 */
                $client->emails()->delete();
                $emails->each(function($email) use ($client) {
                    $client->emails()->create(
                        ['email' => str_replace(['(', ')', ' '], '', $email)]
                    );
                });
            }

            // Upload Profile img
            if($request->hasFile('logo')) {
                $fileName = 'avatar_' . time();
                $path = $this->uploadFile($request, 'logo', "clients/avatars", $fileName, $client->logo);
                $client->logo = $path;
                $client->save();
            }
            return redirect()->route('clients.index')->with([
                'success' => true,
                'title' => 'Atualizado!',
                'message' => 'Cliente atualizado com sucesso',
                'icon' => 'success'
            ]);
        } catch (ValidatorException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

    protected function validateEmail($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return false;
        }
        return true;
    }
}
