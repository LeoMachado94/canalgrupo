<?php

namespace App\Console\Commands;

trait CommandCounterTrait
{
    protected $counter = 1;
    protected $counterFiles = 1;
    protected $limit = 20;

    public function countImport($total)
    {
        if ($this->counter < $total) {
            $this->line("Importados {$this->counter} de {$total}");
        } else {
            $this->info("Concluído: {$total} registros importados");
        }
        $this->counter++;
    }

    public function countImportByStep($limit, $total)
    {
        $parts = ceil(($total/$limit));

        if (($limit * $parts) < $total) {
            $count = $limit * $parts;
            $this->line("Importados {$count} de {$total}");
        } else {
            $this->info("Concluído: {$total} registros importados");
        }
        $this->counter++;
    }
}
