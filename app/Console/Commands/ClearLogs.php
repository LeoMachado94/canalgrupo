<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

// Moved in from hedii/artisan-log-cleaner 2.0 (MIT), which has no release for Laravel 13.
class ClearLogs extends Command
{
    protected $signature = 'log:clear {--keep-last : Whether the last log file should be kept}';

    protected $description = 'Remove every log files in the log directory';

    private $disk;

    public function __construct(Filesystem $disk)
    {
        parent::__construct();

        $this->disk = $disk;
    }

    public function handle(): void
    {
        $files = $this->getLogFiles();

        if ($this->option('keep-last') && $files->count() >= 1) {
            $files->shift();
        }

        $deleted = $this->delete($files);

        if (! $deleted) {
            $this->info('There was no log file to delete in the log folder');
        } elseif ($deleted == 1) {
            $this->info('1 log file has been deleted');
        } else {
            $this->info($deleted.' log files have been deleted');
        }
    }

    private function getLogFiles(): Collection
    {
        return collect(
            $this->disk->allFiles(storage_path('logs'))
        )->sortBy('mtime');
    }

    private function delete(Collection $files): int
    {
        return $files->each(function ($file) {
            $this->disk->delete($file);
        })->count();
    }
}
