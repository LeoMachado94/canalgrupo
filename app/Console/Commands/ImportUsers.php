<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Antigo\Usuario;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportUsers extends Command
{
    use CommandCounterTrait;
    use SaveFileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar usuários do antigo sistema canalgrupo';

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
        $total = Usuario::count();
        $insert=[];
        $duplicated=[];
        $deleted=[];

        $this->line('Buscando usuários...');
        $this->info("Foram encontrados {$total} registros");

        $this->line('Analisando dados...');
        Usuario::orderBy('CODUSUARIO', 'asc')
            ->chunk($limit, function ($usuarios) use ($limit, $total, &$insert, &$duplicated, &$deleted) {

                $usuarios->each(function($usuario) use (&$insert, &$duplicated, &$deleted) {
                    $item = [
                        'id' => $usuario->CODUSUARIO,
                        'name' => (string)$usuario->NOME,
                        'access_level' => $this->getAccessLevel($usuario->TIPO),
                        'email' => $usuario->EMAIL ?? null,
                        'password' => !empty($usuario->SENHA) ? bcrypt($usuario->SENHA) : null,
                        'deleted' => $usuario->EXCLUIDO,
                        'active' => !$usuario->INATIVO
                    ];
                    if (!in_array($item, $insert)) {
                        array_push($insert, $item);
                    } else {
                        array_push($insert, $item);
                        array_push($duplicated, $item);
                    }
                });
            });

        // Save database
        foreach ($insert as $item) {
            if ($item['deleted']) {
                $item['deleted_at'] = Carbon::now();
                array_push($deleted, $item);
            }
            $client = User::create($item);
            $this->countImport($total);
        }

        $this->info('Total de Registros Importados: '.$this->counter);
        $this->warn('Total de Registros Duplicados: '.count($duplicated));
        $this->warn('Total de Registros Com Status Excluído: '.count($deleted));
        foreach ($duplicated as $d) {
            $this->warn(json_encode($d));
        }
    }

    protected function getAccessLevel($level)
    {
        switch ($level) {
            case "Supervisor":
                return 1;
            case "Coordenador":
                return 2;
            case "Monitorador":
                return 3;
            case "Cliente":
                return 4;
            default:
                return null;
        }
    }
}
