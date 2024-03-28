<?php

namespace Cevin\LaravelMultiLanguage;

use Cevin\LaravelMultiLanguage\Route\Dispatcher;
use Illuminate\Routing\Contracts\ControllerDispatcher;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ControllerDispatcher::class, Dispatcher::class);
    }
}
