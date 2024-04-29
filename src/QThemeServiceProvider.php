<?php

namespace Moawiaab\QTheme;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Moawiaab\QTheme\Console\InstallCommand;

class QThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/theme.php', 'theme');

        $this->callAfterResolving(BladeCompiler::class, function () {
            if (config('theme.stack') === 'api') {
            }
        });
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->configureCommands();

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'role-migrations');

        $this->publishes([
            __DIR__ . '/../database/seeders/' => database_path('seeders')
        ], 'role-migrations');

        copy(__DIR__ . '/Models/User.php', app_path('Models/User.php'));
        copy(__DIR__ . '/../database/seeders/DatabaseSeeder.php', app_path('../database/seeders/DatabaseSeeder.php'));
        copy(__DIR__ . '/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));
    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }
}
