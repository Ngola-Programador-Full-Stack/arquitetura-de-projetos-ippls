<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProjetoService;
use App\Models\Projeto;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register()
    {
        $this->app->singleton(ProjetoService::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
