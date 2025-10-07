<?php

namespace App\Console\Commands;

use App\Models\Antigo\Arquivo;
use App\Models\Clipping;
use Illuminate\Console\Command;

class ImportFilesClippings extends Command
{
    use CommandCounterTrait;
    use SaveFileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clipping-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar arquivos de clippings antigo sistema canalgrupo';

    protected $pathFiles = 'http://186.193.176.43/clipping/arquivos/';

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
        $total = Arquivo::all()->count();

        $this->line('Buscando arquivos...');
        $this->info("Foram encontrados {$total} registros");

        $last = Arquivo::orderBy('CODARQUIVO', 'desc')->first();
        $last = $last->id ?? 0;

        $this->line('Analisando dados...');
        Arquivo::orderBy('CODARQUIVO', 'asc')->where('CODARQUIVO', '>', $last)->chunk(
            $limit, function ($arquivos) use ($total) {

            $arquivos->each(function($arquivo) use ($total) {
                if (!empty($arquivo->ARQUIVO) && !empty($arquivo->CODCLIPPING)) {

                    $clipping = Clipping::find($arquivo->CODCLIPPING);
                    if (!empty($clipping)) {
                        $pathToSave = 'clippings/'.$arquivo->CODCLIPPING;

                        //Importar Arquivo
                        $savedFile = $this->saveFile($arquivo->ARQUIVO, $pathToSave, '');
                        $fileName = $savedFile;
                        $fileName = explode('/', $fileName);
                        $fileName = end($fileName);
                        $extension = explode('.', $fileName);
                        $extension = end($extension);

                        $clipping->files()->create([
                            'name' => $fileName,
                            'path' => $savedFile,
                            'extension' => $extension
                        ]);
                    }
                }
                $this->countImport($total);
            });
        });

        foreach ($this->notFoundFiles as $notFound) {
            $this->warn($notFound);
        }
        $this->line('Arquivos Importados: '.$this->counter);
        $this->line('Arquivos Não Encontrados: '.count($this->notFoundFiles));
    }
}
