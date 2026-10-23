<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Client;
use App\Models\Antigo\Cliente;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportClients extends Command
{
    use CommandCounterTrait;
    use SaveFileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clients';

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
        $limit = 20;
        $total = Cliente::count();
        $insert=[];
        $duplicated=[];

        $this->line('Buscando clientes...');
        $this->info("Foram encontrados {$total} registros");

        $this->line('Analisando dados...');
        Cliente::with('cidade')->orderBy('CODCLIENTE', 'asc')
            ->chunk($limit, function ($clientes) use ($limit, $total, &$insert, &$duplicated) {

                $clientes->each(function($cliente) use (&$insert, &$duplicated) {
                    $city = null;
                    $state = null;

                    if (!empty($cliente->estado)) {
                        $state = State::where('title', $cliente->estado->NOMEESTADO)->first();
                    }

                    if (!empty($cliente->cidade)) {
                        $city = City::where(['title' => $cliente->cidade->NOMECIDADE, 'state_id' => $state->id])->first();
                    }

                    if (!empty($cliente->FONE1)) {
                        $phones[] = $cliente->FONE1;
                    }
                    if (!empty($cliente->FONE2)) {
                        $phones[] = $cliente->FONE2;
                    }

                    if (!empty($cliente->USUARIO)) {
                        $user = User::where(['name' => $cliente->NOME])->first();
                    }

                    $item = [
                        'id' => $cliente->CODCLIENTE,
                        'state_id' => $state->id ?? null,
                        'city_id' => $city->id ?? null,
                        'user_id' => $user->id ?? null,
                        'name' => (string)$cliente->NOME,
                        'logo' => $cliente->LOGOMARCA ?? null,
                        'cnpj' => $cliente->CNPJ,
                        'contact' => $cliente->CONTATO ?? null,
                        'email' => $cliente->EMAIL ?? null,
                        'password' => !empty($cliente->SENHA) ? bcrypt($cliente->SENHA) : null,
                        'phones' => $phones ?? null,
                        'active' => !$cliente->INATIVO,
                        'created_at' => $cliente->DTCADASTRO ?? Carbon::now(),
                    ];
                    if (!in_array($item, $insert)) {
                        array_push($insert, $item);
                    } else {
                        array_push($insert, $item);
                        array_push($duplicated, $item);
                    }
                });
            });

            // Download Files
//            foreach ($insert as $k => $file) {
//                if (!empty($file['logo'])) {
//                    var_dump($file['logo']);
//                    // Importar Avatars/Logo
//                    $savedFile = $this->saveFile($file, $file['logo'], 'clients/avatars', 'avatar_');
//                    $insert[$k]['logo'] = $savedFile;
//                } else {
//                    $insert[$k]['logo'] = null;
//                }
//            }

            // Save database
            foreach ($insert as $item) {
                $client = Client::create($item);

                if ($client && !empty($item['phones'])) {
                    $this->savePhones($client, $item['phones']);
                }

                $this->countImport($total);
            }

//            $this->info('Total de Arquivos Baixados: '.$this->getSavedFilesTotal());

            $this->warn('Total de Registros Duplicados: '.count($duplicated));
            foreach ($duplicated as $d) {
                $this->warn(json_encode($d));
        }
    }

    protected function savePhones($client, $phonesArr)
    {
        $phones = collect();
        foreach ($phonesArr as $phone) {
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
}
