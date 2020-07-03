<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\UsersFieldsComposer;

class ViewServideProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Blade::component('shared._card','card');
        View::composer('users._fields', UsersFieldsComposer::class);
        Blade::directive('render', function ($expression) {

            $parts = explode(',', $expression, 2);
            $component = $parts[0];
            $args = trim($parts[1] ?? '[]'); 

            return "<?= app('App\Http\ViewComponents\\\\'.{$component}, {$args})->toHtml(); ?>";
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
