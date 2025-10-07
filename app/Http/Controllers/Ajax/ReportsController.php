<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Mail\ClippingReportMail;
use App\Models\Classification;
use App\Models\Client;
use App\Models\Clipping;
use App\Models\Exhibition;
use App\Models\Middle;
use App\Repositories\ClientRepository;
use App\Repositories\ClippingRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function getGraphsData(Request $request)
    {
        if (empty($request->input('client_id'))  ||
            empty($request->input('middle_id'))  ||
            empty($request->input('start_date')) ||
            empty($request->input('end_date')))
        {
            return response()->json([
                'success' => false,
                'message' => 'Faltam informações para gerar os gráficos'
            ]);
        }

        // Graphs Data ....
        $data['start_date'] = Carbon::createFromFormat('d/m/Y', $request->input('start_date'))
            ->format('Y-m-d');
        $data['end_date'] = $data['end_date'] = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))
            ->format('Y-m-d');
        $data['middle_id'] = $request->input('middle_id');

        $data['client'] = Client::find($request->input('client_id'));
        $data['middle'] = Middle::find($request->input('middle_id'));

        $clippings = Clipping::where(function (Builder $builder) use ($request) {
                // Client
                if (!empty($request->input('client_id'))) {
                    $builder->where('client_id', $request->input('client_id'));
                }
                // Exhibition
                if (!empty($request->input('exhibition_id'))) {
                    $builder->where('exhibition_id', $request->input('exhibition_id'));
                }

                // Middle
                if (!empty($request->input('middle_id'))) {
                    $builder->where('middle_id', $request->input('middle_id'));
                }

                // Classification
                if (!empty($request->input('classification_id'))) {
                    $builder->where('classification_id', $request->input('classification_id'));
                } else {
                    //$builder->whereIn('classification_id', [1,3,4])->get();
                }

                // Source
                if (!empty($request->input('source_id'))) {
                    $builder->where('source_id', $request->input('source_id'));
                }

                // Vehicle
                if (!empty($request->input('vehicle_id'))) {
                    $builder->where('vehicle_id', $request->input('vehicle_id'));
                }

                // User
                if (!empty($request->input('user_id'))) {
                    $builder->where('user_id', $request->input('user_id'));
                }

                // Start Date (veiculação)
                if (!empty($request->input('start_date'))) {
                    $startDate = Carbon::createFromFormat('d/m/Y', $request->input('start_date'));
                    $builder->where('date', '>=', $startDate->format('Y-m-d'));
                }

                // End Date (veiculação)
                if (!empty($request->input('end_date'))) {
                    $endDate = Carbon::createFromFormat('d/m/Y', $request->input('end_date'));
                    $builder->where('date', '<=', $endDate->format('Y-m-d'));
                }

                if (!empty($request->input('title'))) {
                    $title = request()->input('title');
                    $builder->where(function ($builder2) use ($title) {
                        $builder2->orWhereHas('subject', function($builder3) use ($title) {
                            $builder3->where('title', 'like', "%{$title}%");
                        });
                        $builder2->orWhere('title', 'like', "%{$title}%");
                    });
                }

                return $builder;
            })->orderBy('date', 'desc')->get();

        // Clippings By Vehicle
        $clippingsByVechile = [];
        $vehicles = $clippings->groupBy('vehicle_id');
        $vehicles->each(function ($item) use (&$clippingsByVechile, $clippings) {
            array_push($clippingsByVechile, [
                'name' => $item->first()->vehicle->name,
                'qtde' => $item->count(),
                'percent' => round(($item->count()/$clippings->count())*100, 2)
            ]);
        });
        unset($vehicles);

        // Clippings By Classification
        $clippingsByClassification = [];
        $classification = $clippings->sortBy('classification_id')->groupBy('classification_id');
        $classification->each(function ($item) use (&$clippingsByClassification) {
            array_push($clippingsByClassification, [
                'name' => $item->first()->classification->name,
                'qtde' => $item->count(),
                'color' => $this->setColorClassification($item->first()->classification->id)
            ]);
        });
        unset($classification);

        // Clippings By Source
        $clippingsBySource = [];
        $source = $clippings->groupBy('source_id');
        $source->each(function ($item) use (&$clippingsBySource) {
            array_push($clippingsBySource, [
                'name' => $item->first()->source->name ?? 'Não definido',
                'qtde' => $item->count()
            ]);
        });
        unset($source);

        return response()->json([
            'clippings_by_vehicle' => $clippingsByVechile,
            'clippings_by_classification' => $clippingsByClassification,
            'clippings_by_source' => $clippingsBySource
        ]);
    }

    public function setColorClassification($classification)
    {
        switch ($classification) {
            case 1:
                $color = '#29ab3a';
                break;
            case 3:
                $color = '#ba3b11';
                break;
            case 4:
                $color = "#d8b92b";
                break;
            default:
                $color = "#999999";
        }
        return $color;
    }

    public function makePdf(Request $request)
    {
        $data['start_date'] = Carbon::createFromFormat('d/m/Y', $request->input('start_date'))
            ->format('Y-m-d');
        $data['start_date_formatted'] = $request->input('start_date');
        $data['end_date'] = $data['end_date'] = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))
            ->format('Y-m-d');
        $data['end_date_formatted'] = $request->input('end_date');
        // Charts
        $data['chart1'] = $request->input('input_chart_clippings');
        $data['chart2'] = $request->input('input_chart_classification');
        $data['chart3'] = $request->input('input_chart_source');

        $data['client'] = Client::find($request->input('client_id'));
        $data['middle'] = Middle::find($request->input('middle_id'));

        $clippings = Clipping::where(function (Builder $builder) use ($request) {
            // Client
            if (!empty($request->input('client_id'))) {
                $builder->where('client_id', $request->input('client_id'));
            }
            // Exhibition
            if (!empty($request->input('exhibition_id'))) {
                $builder->where('exhibition_id', $request->input('exhibition_id'));
            }

            // Middle
            if (!empty($request->input('middle_id'))) {
                $builder->where('middle_id', $request->input('middle_id'));
            }

            // Classification
            if (!empty($request->input('classification_id'))) {
                $builder->where('classification_id', $request->input('classification_id'));
            } else {
                //$builder->whereIn('classification_id', [1,3,4])->get();
            }

            // Source
            if (!empty($request->input('source_id'))) {
                $builder->where('source_id', $request->input('source_id'));
            }

            // Vehicle
            if (!empty($request->input('vehicle_id'))) {
                $builder->where('vehicle_id', $request->input('vehicle_id'));
            }

            // User
            if (!empty($request->input('user_id'))) {
                $builder->where('user_id', $request->input('user_id'));
            }

            // Start Date (veiculação)
            if (!empty($request->input('start_date'))) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->input('start_date'));
                $builder->where('date', '>=', $startDate->format('Y-m-d'));
            }

            // End Date (veiculação)
            if (!empty($request->input('end_date'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->input('end_date'));
                $builder->where('date', '<=', $endDate->format('Y-m-d'));
            }

            if (!empty($request->input('title'))) {
                $title = request()->input('title');
                $builder->where(function ($builder2) use ($title) {
                    $builder2->orWhereHas('subject', function($builder3) use ($title) {
                        $builder3->where('title', 'like', "%{$title}%");
                    });
                    $builder2->orWhere('title', 'like', "%{$title}%");
                });
            }

            return $builder;
        })->orderBy('date', 'desc')->get();

        if (!empty($request->input('classification_id'))) {
            $data['classification'] = Classification::find($request->input('classification_id'));
        }
        if (!empty($request->input('exhibition_id'))) {
            $data['exhibition'] = Exhibition::find($request->input('exhibition_id'));
        }
        $data['subjects'] = $clippings->groupBy('subject_matter_id');

        $fileName = 'report_'.uniqid().'_'.date('d-m-Y').'.pdf';

        $path = "reports/{$fileName}";
        $pdf = \PDF::loadView('reports.pdf.default', $data)->output();
        Storage::disk('public')->put($path, $pdf);

        return response()->json([
            'success' => true,
            'fileName' => $fileName,
            'client' => $request->input('client_id'),
        ]);
    }

    public function download(Request $request, $fileName)
    {
        $path = 'reports/'.$fileName;
        if (!Storage::disk('public')->exists($path)) {
            dd('Relatório não encontrado');
        }
        $file = Storage::disk('public')->path($path);
        return response()->download($file);
    }

    public function sendMail(Request $request, $clientId)
    {
        try {
            $client = $this->clientRepository->find($clientId);
            $emails = $client->emails->pluck('email')->toArray();
            if (empty($emails) && empty($client->email)) {
                return response()->json([
                    'success' => true,
                    'title' => 'Nenhum email cadastrado!',
                    'message' => 'O cliente não possui um email cadastrado para receber o relatório!',
                    'icon' => 'warning',
                ]);
            }
            if (empty($emails)) {
                Mail::to($client->email)->send(new ClippingReportMail(
                    $client,
                    $request->input('report'),
                    $request->input('month') ?? date('M')
                ));
            } else {
                Mail::to($client->email)->cc($emails)->send(new ClippingReportMail(
                    $client,
                    $request->input('report'),
                    $request->input('month') ?? date('M')
                ));
            }

            return response()->json([
                'success' => true,
                'title' => 'Emails Enviados!',
                'message' => 'Emails enviados com sucesso!',
                'icon' => 'success',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'title' => 'Cliente Não Encontrado!',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Erro ao Enviar Email!',
                'message' => $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
}
