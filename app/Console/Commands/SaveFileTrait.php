<?php

namespace App\Console\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;

trait SaveFileTrait
{
    protected $counterFiles = 1;
    protected $notFoundFiles = [];

    public function saveFile(
        string $fileName,
        string $pathToSave = 'clients/avatars',
        string $prefixToSaveFileName = 'avatar_'
    ) {
        try {
            $httpClient = new \GuzzleHttp\Client(['base_uri' => $this->pathFiles]);
            $response = $httpClient->get($fileName);

            $saveAs = $this->setFileName($fileName, $pathToSave, $prefixToSaveFileName);
            $path = $this->makePathFile($pathToSave, $saveAs);
            Storage::disk('spaces')->put($path, $response->getBody());
            $this->countImportedFiles();
            return $path;
        } catch (GuzzleException $e) {
            array_push($this->notFoundFiles, $fileName);
        }
    }

    public function countImportedFiles($total = null)
    {
        if (!empty($total)) {
            if ($this->counterFiles < $total) {
                $this->line("Arquivos Importados {$this->counter} de {$total}");
            } else {
                $this->info("Concluído: {$total} arquivos importados");
            }
        } else {
            $this->line("{$this->counterFiles} arquivos importados");
        }
        $this->counterFiles++;
    }

    protected function makePathFile($path, $fileName)
    {
        $path = $path.'/'.$fileName;
        return str_replace('//', '/', $path);
    }

    protected function checkPathFile($path)
    {
        return str_replace('//', '/', $path);
    }

    protected function getFileExtension($fileName)
    {
        $fileName = explode('.', $fileName);
        return strtolower(end($fileName));
    }

    protected function setFileName($fileName, $pathToSave, $prefixToSaveFileName = '') {
        $extension = $this->getFileExtension($fileName);
        $fileToSave = $prefixToSaveFileName. rand(0,999999) . time() . '.' . $extension;
        return $fileToSave;
    }

    public function getSavedFilesTotal()
    {
        return $this->counterFiles - 1;
    }
}
