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

class ImportClippings extends Command
{
    use CommandCounterTrait;
    use SaveFileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clippings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar clippings do antigo sistema canalgrupo';
    protected $subjectId = 1;
    protected $slugsRecreated = 0;

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
        $older = ClippingOld::all()->pluck('CODCLIPPING');
        $older = $older->toArray();
        $new = Clipping::all('id')->pluck('id');
        $new = $new->toArray();
        $diff = array_diff($older, $new);
        dd($diff);

        dd('die');
        $limit = 800;
        $last = Clipping::orderBy('id', 'desc')->limit(1)->first();
        $last = $last->id ?? 0;

        $total = ClippingOld::where('CODCLIPPING', '>', $last)->count();

        // Todos assuntos inseridos / aguardando
        $addedSubjects = collect();

        // Todos clippings inseridos / aguardando
        $slugClippings = collect();

        // Clippings inseridos a cada ciclo de chunk
        $insert = collect();

        $classifications = Classification::all();
        $exhibitions = Exhibition::all();
        $sources = Source::all();
        $middles = Middle::all();
        $clients = Client::all();
        $vehicles = Vehicle::all();
        $editorials = Editorial::all();
        $users = User::all();

        $this->line('Buscando clippings...');
        $this->info("Foram encontrados {$total} registros");

        $this->line('Analisando dados...');
        ClippingOld::orderBy('CODCLIPPING', 'asc')->where('CODCLIPPING', '>', $last)->chunk(
            $limit, function ($clippings) use (
                &$slugClippings, &$addedSubjects, &$insert, $total, $limit, $classifications,
                $exhibitions, $sources, $middles, $clients, $vehicles, $editorials, $users
            ) {
                //Subjects Temp Arr
                $subjectsInsert = collect();

                // Each Clippings chunk
                $clippings->each(function($clipping) use (
                    &$slugClippings, &$addedSubjects, &$insert, $classifications, $total,
                    $exhibitions, $sources, $middles, $clients, $vehicles, &$subjectsInsert,
                    $editorials, $users
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

                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $clipping->DTCADASTRO);
                    $dateSubject = $date->format('Y') . '-' . $date->format('m') . '-01';

                    if (!empty($client)) {
                        // Cria o assunto Arr
                        $subjectItem = [
                            'id' => $this->subjectId,
                            'client_id' => $client->id,
                            'user_id' => $user->id ?? null,
                            'title' => $clipping->TITULO,
                            'date' => $dateSubject,
                            'created_at' => $clipping->DTCADASTRO ?? Carbon::now(),
                            'updated_at' => $clipping->DTCADASTRO ?? Carbon::now()
                        ];

                        // Verifica se o assunto já está no array de insert
                        $hasSubject = $addedSubjects->where('client_id', $client->id)
                                        ->where('title', $clipping->TITULO)
                                        ->where('date', $dateSubject)->first();

                        if(empty($hasSubject)) { // Não existe no array
                            $addedSubjects->push(collect($subjectItem)->except([
                                'user_id', 'created_at', 'updated_at'
                            ])); // Todos assuntos inseridos/aguardando
                            $subjectsInsert->push($subjectItem);
                            $subject = new SubjectMatter($subjectItem);
                            $this->subjectId++; // Simula o auto increment
                        } else {
                            $subject = new SubjectMatter($hasSubject->toArray());
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

                        // Adiciona o slug aos já utilizados
                        $slugCount = $slugClippings->where('slug', $item['slug'])->count();
                        $slugClippings->push(['slug' => $item['slug']]);

                        // Se já existe algum clipping com o slug criado, cria novamente o slug
                        if (!empty($slugCount)) {
                            // Cria novamente o slug (diferente dos que já existem no banco)
                            $this->slugsRecreated++;
                            $item['slug'] = $item['slug'].'-'.$slugCount;
                        }

                        $insert->push($item);
                        $this->countImport($total);
                    }
                });

                SubjectMatter::insert($subjectsInsert->all());
                $subjectsInsert = collect();

                Clipping::insert($insert->toArray());
                $insert = collect();
        });
        $this->info('Total de Registros Encontrados: '.$total);
        $this->info('Total de Registros Importados: '.$this->counter);
        $this->info('Total de Slugs Recriados (clippings): '.$this->slugsRecreated);
        $this->info('Total de Registros Importados (ASSUNTOS): '.$addedSubjects->count());
        $this->info('Total de Registros NÃO Importados: '.($total-$this->counter));
        $this->line('-------------------------------------------------------------------------------------');
        $this->info('IMPORTAÇÃO CONCLUÍDA COM SUCESSO!');
        $this->line('-------------------------------------------------------------------------------------');
    }
}
