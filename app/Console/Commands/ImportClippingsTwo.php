<?php

namespace App\Console\Commands;

use App\Models\Classification;
use App\Models\Client;
use App\Models\Clipping;
use App\Models\Antigo\ClippingOld;
use App\Models\Editorial;
use App\Models\Exhibition;
use App\Models\Middle;
use App\Models\Source;
use App\Models\SubjectMatter;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Console\Command;

class ImportClippingsTwo extends Command
{
    use CommandCounterTrait;
    use SaveFileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clippings-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar clippings do antigo sistema canalgrupo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->import();
    }

    public function import()
    {
        $limit = 800;
        $last = Clipping::orderBy('id', 'desc')->limit(1)->first();
        $last = $last->id ?? 0;

        $total = ClippingOld::where('CODCLIPPING', '>', $last)->count();

        $classifications = Classification::all();
        $exhibitions = Exhibition::all();
        $sources = Source::all();
        $middles = Middle::all();
        $clients = Client::all();
        $vehicles = Vehicle::all();
        $editorials = Editorial::all();
        $users = User::all();
        $clippingProblem = [];

        $this->line('Buscando clippings...');
        $this->info("Foram encontrados {$total} registros");

        $this->line('Analisando dados...');
        ClippingOld::orderBy('CODCLIPPING', 'asc')->where('CODCLIPPING', '>', $last)->chunk(
            $limit, function ($clippings) use (
                $total, $limit, $classifications, $exhibitions, $sources,
                $middles, $clients, $vehicles, $editorials, $users, &$clippingProblem
            ) {
                // Each Clippings chunk
                $clippings->each(function($clipping) use (
                    $classifications, $total, $exhibitions, $sources, $middles,
                    $clients, $vehicles, $editorials, $users, &$clippingProblem
                ) {
                    $client = null; $middle = null; $subject = null;
                    $vehicle = null; $editorial = null; $user = null;
                    $classification = null; $exhibition = null; $source = null;

                    if (!empty($clipping->CODCLIENTE)) {
                        $client = $clients->where('id', $clipping->CODCLIENTE)->first();
                    }
                    if (!empty($clipping->MEIO)) {
                        $middle = $middles->where('name', $clipping->MEIO)->first();
                    }
                    if (!empty($clipping->CODVEICULO)) {
                        $vehicle = $vehicles->where('id', $clipping->CODVEICULO)->first();
                    }
                    if (!empty($clipping->CODEDITORIAL)) {
                        $editorial = $editorials->where('id', $clipping->CODEDITORIAL)->first();
                    }
                    if (!empty($clipping->USUARIO)) {
                        $user = $users->where('name', $clipping->USUARIO)->first();
                    }
                    if (!empty($clipping->TEMPERATURA)) {
                        $classification = $classifications->where('name', $clipping->TEMPERATURA)->first();
                    }
                    if (!empty($clipping->EXIBICAO)) {
                        $exhibition = $exhibitions->where('name', $clipping->EXIBICAO)->first();
                    }
                    if (!empty($clipping->TIPO)) {
                        $source = $sources->where('name', $clipping->TIPO)->first();
                    }

                    if (!empty($client)) {
                        // Cria o assunto
                        if (!empty($clipping->assunto)) {
                            // Tem o assunto no novo banco ??
                            $hasSubjectInNewDb = SubjectMatter::where([
                                'client_id' => $client->id,
                                'title' => $clipping->assunto->NOME //antigo assunto
                            ])->first();

                            // Se tiver use ele, caso contrário cadastre
                            if (!empty($hasSubjectInNewDb)) {
                                $subject = $hasSubjectInNewDb;
                            } else {
                                $subject = SubjectMatter::create([
                                    'client_id' => $client->id,
                                    'user_id' => $user->id ?? null,
                                    'title' => $clipping->TITULO,
                                    'created_at' => $clipping->DTCADASTRO ?? Carbon::now(),
                                    'updated_at' => $clipping->DTCADASTRO ?? Carbon::now()
                                ]);
                            }
                        }

                        // Cria o Item
                        $item = [
                            'id' => $clipping->CODCLIPPING,
                            'client_id' => $client->id ?? null,
                            'middle_id' => $middle->id ?? null,
                            'subject_matter_id' => $subject->id ?? null,
                            'vehicle_id' => $vehicle->id ?? null,
                            'editorial_id' => $editorial->id ?? null,
                            'user_id' => $user->id ?? null,
                            'classification_id' => $classification->id ?? null, //TEMPERATURA
                            'exhibition_id' => $exhibition->id ?? null, // EXIBICAO
                            'source_id' => $source->id ?? null, // TIPO (Gerada, Espontanea, Mista)
                            'title' => $clipping->TITULO ?? null,
                            'slug' => SlugService::createSlug(Clipping::class, 'slug', $clipping->TITULO),
                            'date' => $clipping->DATA ?? Carbon::now(),
                            'review' => $clipping->RESENHA ?? null,
                            'created_at' => $clipping->DTCADASTRO ?? Carbon::now(),
                            'updated_at' => $clipping->DTCADASTRO ?? Carbon::now(),
                            'active' => !$clipping->INATIVO
                        ];

                        Clipping::create($item);
                        $this->countImport($total);
                    } else {
                        array_push($clippingProblem, $clipping->toJson());
                    }
                });
        });
        $this->info('Total de Registros Encontrados: '.$total);
        $this->info('Total de Registros Importados: '.$this->counter);
        $this->info('Total de Registros NÃO Importados: '.($total-$this->counter));
        $this->info('Clippings com problema.....');
        foreach($clippingProblem as $problem) {
            $this->warn($problem);
        }
        $this->line('-------------------------------------------------------------------------------------');
        $this->info('IMPORTAÇÃO CONCLUÍDA COM SUCESSO!');
        $this->line('-------------------------------------------------------------------------------------');
    }
}
