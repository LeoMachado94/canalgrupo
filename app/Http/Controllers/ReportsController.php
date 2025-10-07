<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use App\Repositories\ClippingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportsController extends Controller
{
    protected $clientRepository;
    protected $repository; // Clipping

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClippingRepository $repository, ClientRepository $clientRepository)
    {
        $this->repository = $repository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Show the application users list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('reports.index');
    }

    public function show(Request $request, $file)
    {
        $fileName = $file;
        $filepath = "reports/{$fileName}";
        return view('reports.show', compact('filepath', 'fileName'));
    }

    public function download(Request $request, $fileName)
    {
        $path = "reports/{$fileName}";
        if (!Storage::disk('spaces')->exists($path)) {
            dd('Relatório não encontrado');
        }

        $url = Storage::disk('spaces')->url($path);

        $mime = Storage::disk('spaces')->getDriver()->getMimetype($url);
        $size = Storage::disk('spaces')->getDriver()->getSize($url);

        $response =  [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Content-Transfer-Encoding' => 'binary',
        ];

        return response()->make(Storage::disk('spaces')->get($url), 200, $response);
    }
}
