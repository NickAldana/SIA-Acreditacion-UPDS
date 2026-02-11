<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Registramos el middleware de seguridad global (Ya lo tenías)
        $middleware->web(append: [
            \App\Http\Middleware\CheckUserActive::class,
        ]);
        
        // 2. REGISTRAMOS EL ALIAS PARA LA JERARQUÍA
        // Esto permite usar 'jerarquia:N' en los archivos de rutas
        $middleware->alias([
            'jerarquia' => \App\Http\Middleware\HierarchicalAccess::class,
        ]);
        
        // Redirección personalizada si no está logueado
        $middleware->redirectGuestsTo('/login');
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();