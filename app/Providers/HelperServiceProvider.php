<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadHelpers();
    }

    public function boot(Router $router, Dispatcher $event): void
    {
        $this->loadBladeDirectives();
    }

    protected function loadHelpers(): void
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    protected function loadBladeDirectives(): void
    {

        //app()->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
        // @admin directives
        Blade::if('admin', function () {
            return !auth()->guest() && auth()->user()->isAdmin();
        });

        //@superadmin directives
        Blade::if('superadmin', function () {
            return !auth()->guest() && auth()->user()->isSuperAdmin();
        });

        //@active directives
        Blade::if('active', function () {
            return !auth()->guest() && auth()->user()->isActive();
        });

        // home directives
        Blade::if('home', function () {
            return request()->is('/');
        });
    }
}
