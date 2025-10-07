<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Antigo\ClippingOld;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportSubjects extends Command
{
    use CommandCounterTrait;
    use SaveFileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:subjects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar assuntos do antigo sistema canalgrupo';

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
        $limit = 1000;
        $total = ClippingOld::all()->count();

        // Todos assuntos inseridos / aguardando
        $addedSubjects = collect();

        $clients = Client::all();
        $users = User::all();

        $this->line('Buscando assuntos...');
        $this->info("Foram encontrados {$total} registros");

        $this->line('Analisando dados...');
        ClippingOld::orderBy('CODCLIPPING', 'asc')->where('CODCLIPPING', '>', $last)->chunk(
            $limit, function ($clippings) use (
                &$addedSubjects, $total, $clients, $users
            ) {
                //Subjects Temp Arr
                $subjectsInsert = collect();

                // Each Clippings chunk
                $clippings->each(function($clipping) use (
                    &$addedSubjects, $total, $clients, $users, &$subjectsInsert
                ) {
                    $client = null; $user = null;

                    if (!empty($clipping->CODCLIENTE)) {
                        $client = $clients->where('id', $clipping->CODCLIENTE)->first();
                    }
                    if (!empty($clipping->USUARIO)) {
                        $user = $users->where('name', $clipping->USUARIO)->first();
                    }

                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $clipping->DTCADASTRO);
                    $dateSubject = $date->format('Y') . '-' . $date->format('m') . '-01';

                    if (!empty($client)) {
                        // Cria o assunto Arr
                        $subjectItem = [
                            'client_id' => $client->id,
                            'user_id' => $user->id ?? null,
                            'title' => $clipping->TITULO,
                            'date' => $dateSubject,
                            'created_at' => $clipping->DTCADASTRO ?? Carbon::now(),
                            'updated_at' => $clipping->DTCADASTRO ?? Carbon::now()
                        ];

                        // Verifica se o assunto já está na collection de "inseridos"
                        $hasSubject = $addedSubjects->where('client_id', $client->id)
                                        ->where('title', $clipping->TITULO)
                                        ->where('date', $dateSubject)->first();

                        if(!empty($hasSubject)) { // Já existe na collection
                            $subject = new SubjectMatter($hasSubject->toArray());
                        } else { // Não existe na collection
                            $addedSubjects->push(collect($subjectItem)->except([
                                'id', 'user_id', 'created_at', 'updated_at'
                            ])); // Todos assuntos inseridos/aguardando
                            $subjectsInsert->push($subjectItem);
                            $subject = new SubjectMatter($subjectItem);
                        }
                        $this->countImport($total);
                    }
                });

                SubjectMatter::insert($subjectsInsert->all());
                $subjectsInsert = collect();
        });
        $this->info('Total de Registros Encontrados: '.$total);
        $this->info('Total de Registros Importados: '.$this->counter);
        $this->info('Total de Registros NÃO Importados: '.($total-$addedSubjects->count()));
        $this->line('-------------------------------------------------------------------------------------');
        $this->info('IMPORTAÇÃO CONCLUÍDA COM SUCESSO!');
        $this->line('-------------------------------------------------------------------------------------');
    }
}
