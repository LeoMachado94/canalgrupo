<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Middle;
use App\Models\State;
use App\Models\Vehicle;
use App\Models\Antigo\Veiculo;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportVehicles extends Command
{
    use CommandCounterTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:vehicles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar veículos do antigo sistema canalgrupo';

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
        $total = Veiculo::count();
        $insert=[];
        $duplicated=[];

        $this->line('Buscando veículos...');
        $this->info("Foram encontrados {$total} registros");

        $this->line('Analisando dados...');
        Veiculo::with('cidade')->orderBy('CODVEICULO', 'asc')
            ->chunk($this->limit, function ($veiculos) use (&$insert, &$duplicated) {

            $veiculos->each(function($veiculo) use (&$insert, &$duplicated) {
                $city = null;
                $state = null;
                $middle = null;

                if (!empty($veiculo->estado)) {
                    $state = State::where('title', $veiculo->estado->NOMEESTADO)->first();
                }

                if (!empty($veiculo->cidade)) {
                    $city = City::where(['title' => $veiculo->cidade->NOMECIDADE, 'state_id' => $state->id])->first();
                }

                $middle = Middle::where('name', $veiculo->TIPO)->first();

                $item = [
                    'id' => $veiculo->CODVEICULO,
                    'name' => (string)$veiculo->NOME,
                    'city_id' => $city->id ?? null,
                    'state_id' => $state->id ?? null,
                    'middle_id' => $middle->id ?? null,
                    'description' => (string)$veiculo->NOME,
                    'created_at' => $veiculo->DATA ?? Carbon::now(),
                    'active' => !$veiculo->INATIVO
                ];
                if (!in_array($item, $insert)) {
                    array_push($insert, $item);
                } else {
                    array_push($insert, $item);
                    array_push($duplicated, $item);
                }
            });
        });

        foreach ($insert as $item) {
            Vehicle::create($item);
            $this->countImport($total);
        }

        $this->warn('Total de Registros Duplicados: '.count($duplicated));
        foreach ($duplicated as $d) {
            $this->warn(json_encode($d));
        }
    }
}
