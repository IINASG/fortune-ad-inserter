<?php

namespace Iinasg\FortuneAdInserter;

use Illuminate\Support\ServiceProvider;
use Iinasg\FortuneAdInserter\Commands\FortuneAdInserterCommand;

class FortuneAdInserterServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/fortune-ad-inserter.php' => config_path('fortune-ad-inserter.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/fortune-ad-inserter'),
            ], 'views');

            $this->commands([
                FortuneAdInserterCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'fortune-ad-inserter');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fortune-ad-inserter.php', 'fortune-ad-inserter');
    }

}
