<?php

namespace App\Console\Commands;

use App\Models\Editorial;
use App\Models\Antigo\EditorialOld;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportEditorials extends Command
{
    use CommandCounterTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:editorials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar editoriais do antigo sistema canalgrupo';

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
        $total = EditorialOld::count();
        $insert=[];
        $duplicated=[];
        $inconsistent=[];

        $this->line('Buscando editoriais...');
        $this->info("Foram encontrados {$total} registros");

        $this->line('Analisando dados...');
        EditorialOld::orderBy('CODEDITORIAL', 'asc')
            ->chunk($limit, function ($editoriais) use (&$insert, &$duplicated, &$inconsistent) {

                $editoriais->each(function($editorial) use (&$insert, &$duplicated, &$inconsistent) {
                    if (!empty($editorial->CODVEICULO)) {
                        $vehicle = Vehicle::find($editorial->CODVEICULO);
                    }

                    if (!empty($editorial->HORARIO)) {
                        $hour = Carbon::createFromFormat('H:i', trim($editorial->HORARIO))->format('H:i:s');
                    }

                    $responsible = !empty($editorial->RESPONSAVEL) ? $editorial->RESPONSAVEL : null;
                    $description = !empty($editorial->DESCRICAO) && strlen($editorial->DESCRICAO) >= 3 ? $editorial->DESCRICAO : null;

                    $item = [
                        'id' => (int) $editorial->CODEDITORIAL,
                        'vehicle_id' => $vehicle->id ?? null,
                        'title' => (string)$editorial->TITULO,
                        'hour' => $hour ?? null,
                        'responsible' => $responsible,
                        'description' => $description,
                        'active' => !$editorial->INATIVO
                    ];

                    // Adiciona apenas se veículo existir
                    if (!empty($vehicle)) {
                        if (!in_array($item, $insert)) {
                            // Dados INSERT
                            array_push($insert, $item);
                        } else {
                            // Duplicados
                            array_push($duplicated, $item);
                        }
                    } else {
                        // Dados inconsistentes
                        array_push($inconsistent, $item);
                    }
                });
            });

            foreach ($insert as $item) {
                Editorial::create($item);
                $this->countImport($total);
            }

        $this->warn('Total de Registros Duplicados: '.count($duplicated));
        foreach ($duplicated as $d) {
            $this->warn(json_encode($d));
        }

        $this->warn('Total de Registros Inconsistentes: '.count($inconsistent));
        foreach ($inconsistent as $i) {
            $this->warn(json_encode($i));
        }
    }
}
