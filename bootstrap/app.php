 <?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(                                         //routing for application
        web: __DIR__.'/../routes/web.php',                 //web routes file for standard browser requests.
        api: __DIR__.'/../routes/api.php',##                 //API routes file for API endpoints
        commands: __DIR__.'/../routes/console.php',           //Console commands routes file
        health: '/up',                                         //Health check endpoint
    )
    ->withMiddleware(function (Middleware $middleware): void {              //configures global middleware
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {                 //configures exception handling
        //
    })->create();
