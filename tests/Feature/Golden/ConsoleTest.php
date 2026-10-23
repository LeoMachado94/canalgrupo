<?php

namespace Tests\Feature\Golden;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;
use Tests\TestCase;

class ConsoleTest extends TestCase
{
    use \Tests\Concerns\AssertsGolden;

    public function test_app_command_signatures(): void
    {
        $commands = [];
        foreach ($this->app->make(Kernel::class)->all() as $name => $command) {
            $class = get_class($command);
            if (! Str::startsWith($class, 'App\\') && $name !== 'log:clear') {
                continue;
            }

            $definition = $command->getDefinition();
            $commands[$name] = [
                'description' => $command->getDescription(),
                'arguments' => array_map(function ($argument) {
                    return [$argument->isRequired(), $argument->isArray(), $argument->getDefault()];
                }, $definition->getArguments()),
                'options' => array_map(function ($option) {
                    return [$option->getShortcut(), $option->acceptValue(), $option->isValueRequired(), $option->getDefault()];
                }, array_diff_key($definition->getOptions(), array_flip([
                    'help', 'quiet', 'verbose', 'version', 'ansi', 'no-ansi', 'no-interaction', 'env', 'silent',
                ]))),
            ];
        }
        ksort($commands);

        $this->assertGoldenJson('console/commands', $commands);
    }
}
