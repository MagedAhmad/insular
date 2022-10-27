<?php

namespace MagedAhmad\Insular;

use Godruoyi\Snowflake\Snowflake;
use Illuminate\Support\ServiceProvider;
use Godruoyi\Snowflake\LaravelSequenceResolver;
use MagedAhmad\Insular\Commands\GenerateJobCommand;
use MagedAhmad\Insular\Commands\GenerateTypeCommand;
use MagedAhmad\Insular\Commands\GenerateModelCommand;
use MagedAhmad\Insular\Commands\GenerateModuleCommand;
use MagedAhmad\Insular\Commands\GenerateFeatureCommand;
use MagedAhmad\Insular\Commands\GenerateRequestCommand;
use MagedAhmad\Insular\Commands\GenerateResourceCommand;
use MagedAhmad\Insular\Commands\GenerateExceptionCommand;
use MagedAhmad\Insular\Commands\GenerateMigrationCommand;
use MagedAhmad\Insular\Commands\GenerateOperationCommand;
use MagedAhmad\Insular\Commands\GenerateControllerCommand;

class InsularServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('insular.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                GenerateModuleCommand::class,
                GenerateOperationCommand::class,
                GenerateControllerCommand::class,
                GenerateMigrationCommand::class,
                GenerateModelCommand::class,
                GenerateTypeCommand::class,
                GenerateResourceCommand::class,
                GenerateRequestCommand::class,
                GenerateFeatureCommand::class,
                GenerateJobCommand::class,
                GenerateExceptionCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'insular');

        // Register the main class to use with the facade
        $this->app->singleton('insular', function () {
            return new Insular;
        });

        $this->app->bind('snowflake', function() {
            return (new Snowflake(
                config('insular.snowflake.data_center'),
                config('insular.snowflake.worker_node'))
            )
            ->setStartTimeStamp(strtotime('2022-01-01') * 1000)
            ->setSequenceResolver(new LaravelSequenceResolver($this->app->get('cache')->store()));
        });
    }
}
