<?php

use App\Console\Commands\ImportClippingsTwo;
use App\Http\Middleware\Cors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    // ImportSubjectsTwo also claims "import:clippings-db"; registering this one last keeps it as the command that runs.
    ->withCommands([ImportClippingsTwo::class])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cors' => Cors::class,
        ]);

        $middleware->api(prepend: ['throttle:60,1']);

        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo('/home');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
