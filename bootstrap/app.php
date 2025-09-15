<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->redirectGuestsTo(function(){
          if (Str::startsWith(Route::currentRouteName(), 'admin.')){
            return route('admin.index');
          }

          return route('home');
        });

        $middleware->redirectUsersTo(function(){
          if (Str::startsWith(Route::currentRouteName(), 'admin.')){
            return route('admin.dashboard');
          }

          return route('home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
