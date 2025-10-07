<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;

class ImportAvatarsClients extends Command
{
    use CommandCounterTrait;
    use SaveFileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:client-avatar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar clientes do antigo sistema canalgrupo';

    protected $pathFiles = 'http://186.193.176.43/clipping/logomarcas/';

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
        $total = Client::count();
        $insert=[];
        $duplicated=[];

        $this->line('Buscando clientes...');
        $this->info("Foram encontrados {$total} registros");

        $this->line('Analisando dados...');
        $client = Client::all();
        $client->each(function($client) use (&$insert) {

            if (!empty($client->logo)) {
                //Importar Avatars/Logo
                $savedFile = $this->saveFile($client->logo, 'clients/avatars', 'avatar_');
                $client->logo = $savedFile;
                $client->save();
            }
        });

        $this->error("Arquivos não encontrados: ".count($this->notFoundFiles));
        foreach ($this->notFoundFiles as $notFound) {
            $this->warn($notFound);
        }
    }
}
