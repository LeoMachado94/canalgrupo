<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\SubjectMatter;
use App\Models\Antigo\ClippingOld;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportSubjectsTwo extends Command
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

    protected $created = 0;

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

        $clients = Client::all();
        $users = User::all();

        $this->line('Buscando assuntos...');
        $this->info("Foram encontrados {$total} registros");

        $last = ClippingOld::orderBy('CODCLIPPING', 'desc')->first();
        $last = $last->id ?? 0;

        $this->line('Analisando dados...');
        ClippingOld::orderBy('CODCLIPPING', 'asc')->where('CODCLIPPING', '>', $last)->chunk(
            $limit, function ($clippings) use ($total, $clients, $users) {
                // Each Clippings chunk
                $clippings->each(function($clipping) use ($total, $clients, $users) {
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

                        $hasInDb = SubjectMatter::where([
                            'client_id' => $client->id,
                            'title' => $clipping->TITULO,
                            'date' => $dateSubject
                        ])->first();

                        if (empty($hasInDb)) {
                            SubjectMatter::create($subjectItem);
                            $this->created++;
                        }

                        $this->countImport($total);
                    }
                });
        });
        $this->info('Total de Registros Encontrados: '.$total);
        $this->info('Total de Registros Importados: '.$this->created);
        $this->info('Total de Registros NÃO Importados: '.($total-$this->created));
        $this->line('-------------------------------------------------------------------------------------');
        $this->info('IMPORTAÇÃO CONCLUÍDA COM SUCESSO!');
        $this->line('-------------------------------------------------------------------------------------');
    }
}
