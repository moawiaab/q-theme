<?php

namespace Moawiaab\QTheme\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

class InstallCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'q-theme:install {stack : The development stack that should be installed (quasar,vuetify, api)}
                                                  {--dark : Indicate that dark mode support  be installed}
                                                  {--locker : Indicate that Treasury management mode support support be installed}
                                                  {--expanse : Indicate that expanse management mode support support be installed}
                                                  {--client : Indicate that client management mode support  be installed}
                                                  {--supplier : Indicate that supplier management mode support  be installed}
                                                  {--product : Indicate that product management mode support  be installed}
                                                  {--lang : Make Arabic the default language}
                                                  {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the q-theme components and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        if (!in_array($this->argument('stack'), ['quasar', 'vuetify'])) {
            $this->components->error('Invalid stack. Supported stacks are [quasar] , [vuetify] and [api].');

            return 1;
        }

        // set Middleware classes
        $this->installMiddleware(['\Moawiaab\QTheme\Http\Middleware\AuthGates::class']);

        if ($this->argument('stack') === 'vuetify' || $this->argument('stack') === 'quasar') {
            // $this->runCommands(['php artisan ui vue --auth']);
            $this->updateNodePackages(function ($packages) {
                return [
                    "postcss-rtlcss" => "^5.1.2",
                    "sass" => "^1.75.0",
                ] + $packages;
            });

            $this->updateNodePackages(function ($packages) {
                return [
                    "pinia" => "^2.1.7",
                    "pinia-plugin-persistedstate" => "^3.2.1",
                    "vue-i18n" => "^9.12.1",
                    "vue-chartjs" => "^5.2.0",
                    "chart.js" => "^4.3.3",
                ] + $packages;
            }, false);

            (new Filesystem)->copyDirectory(__DIR__ . '/../Http/Requests', app_path('Http/Requests'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../Http/Resources/show', app_path('Http/Resources'));

            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/views', resource_path('views'));

            // copy(__DIR__ . '/../Providers/RouteServiceProvider.php', app_path('Providers/RouteServiceProvider.php'));
            // copy(__DIR__ . '/../../routes/api.php', base_path('routes/api.php'));
            copy(__DIR__ . '/../../routes/web.php', base_path('routes/web.php'));


            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/public', base_path('public'));
            // (new Filesystem)->copy(__DIR__ . '/../../stubs/public/Khalid-Art-Bold.ttf', base_path('public/Khalid-Art-Bold.ttf'));
        }

        // if ($this->option('expanse')) {
        //     if (file_exists(database_path('seeders/PermissionSeeder.php'))) {
        //         $this->replaceInFile('//expanse', '', database_path('seeders/PermissionSeeder.php'));
        //         $this->replaceInFile('//locker', '', database_path('seeders/PermissionSeeder.php'));
        //     } else {
        //         $this->replaceInFile('//expanse', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
        //         $this->replaceInFile('//locker', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
        //     }
        //     $this->replaceInFile('//expanse', '', base_path('routes/api.php'));
        //     $this->replaceInFile('//locker', '', base_path('routes/api.php'));
        // }

        // Install Stack...
        if ($this->argument('stack') === 'vuetify') {
            if (!$this->installVuetifyStack()) {
                return 1;
            }
        } elseif ($this->argument('stack') === 'quasar') {
            if (!$this->installQuasarStack()) {
                return 1;
            }
        }
    }

    /**
     * Install the Api stack into the application.
     *
     * @return bool
     */
    protected function installVuetifyStack()
    {
        // if (file_exists(base_path('postcss.config.js'))) {
        //     unlink(base_path('postcss.config.js'));
        // }

        // if (file_exists(base_path('vite.config.js'))) {
        //     unlink(base_path('vite.config.js'));
        // }

        // if (file_exists(base_path('postcss.config.cjs'))) {
        //     unlink(base_path('postcss.config.cjs'));
        // }
        // copy(__DIR__ . '/../../stubs/vuetify/vite.config.js', base_path('vite.config.js'));
        // (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/vuetify/resources/sass', resource_path('sass'));
        // (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/vuetify/resources/js', resource_path('js'));
        // (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/vuetify/resources/css', resource_path('css'));

        // $this->updateNodePackages(function ($packages) {
        //     return [
        //         "vite-plugin-vuetify" => "^1.0.2",
        //         "vuetify" => "^3.3.15",
        //         "vue3-easy-data-table"  => "^1.5.47",
        //         "@mdi/font" => "^7.2.96",
        //         "@casl/ability" => "^6.5.0",
        //         "splitpanes" => "^3.1.5",
        //         "@casl/vue" => "^2.2.1",
        //         "xlsx" => "^0.18.5",
        //         "vue-fullscreen" => "^2.6.1",
        //         "vue-i18n" => "^9.3.0-beta.25",
        //         "@vueuse/components" => "^10.4.1",
        //         "@vueuse/core" => "^10.4.1"
        //     ] + $packages;
        // }, false);

        // if (file_exists(base_path('pnpm-lock.yaml'))) {
        //     $this->runCommands(['pnpm install', 'pnpm run build']);
        // } elseif (file_exists(base_path('yarn.lock'))) {
        //     $this->runCommands(['yarn install', 'yarn run build']);
        // } else {
        //     $this->runCommands(['npm install --force', 'npm run build']);
        // }

        // $this->line('');
        // $this->components->info('vuetify theme installed successfully.');

        return true;
    }


    /**
     * Install the Inertia stack into the application.
     *
     * @return bool
     */
    protected function installQuasarStack()
    {
        if (file_exists(base_path('postcss.config.js'))) {
            unlink(base_path('postcss.config.js'));
        }

        if (file_exists(base_path('vite.config.js'))) {
            unlink(base_path('vite.config.js'));
        }
        copy(__DIR__ . '/../../stubs/quasar/postcss.config.cjs', base_path('postcss.config.cjs'));
        copy(__DIR__ . '/../../stubs/quasar/vite.config.js', base_path('vite.config.js'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/quasar/resources/sass', resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/quasar/resources/js', resource_path('js'));

        $this->updateNodePackages(function ($packages) {
            return [
                "@quasar/vite-plugin" => "^1.4.1",
                "postcss-rtlcss" => "^4.0.7"
            ] + $packages;
        });

        $this->updateNodePackages(function ($packages) {
            return [
                "@quasar/extras" => "^1.16.11",
                "quasar" => "^2.15.2",
            ] + $packages;
        }, false);


        if ($this->option('lang')) {
            // $this->replaceInFile('"en-US";', '"ar";', resource_path('js/app.ts'));
        }

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install --force', 'npm run build']);
        }


        $this->line('');
        $this->components->info('quasar theme installed successfully.');

        return true;
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> ' . $e->getMessage() . PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    ' . $line);
        });
    }

    protected function installMiddleware($names, $group = 'web', $modifier = 'append')
    {
        $bootstrapApp = file_get_contents(base_path('bootstrap/app.php'));

        $names = collect(Arr::wrap($names))
            ->filter(fn ($name) => ! Str::contains($bootstrapApp, $name))
            ->whenNotEmpty(function ($names) use ($bootstrapApp, $group, $modifier) {
                $names = $names->map(fn ($name) => "$name")->implode(','.PHP_EOL.'            ');

                $bootstrapApp = str_replace(
                    '->withMiddleware(function (Middleware $middleware) {',
                    '->withMiddleware(function (Middleware $middleware) {'
                        .PHP_EOL."        \$middleware->$group($modifier: ["
                        .PHP_EOL."            $names,"
                        .PHP_EOL.'        ]);'
                        .PHP_EOL,
                    $bootstrapApp,
                );

                file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp);
            });
    }


    protected function promptForMissingArgumentsUsing()
    {
        return [
            'stack' => fn () => select(
                label: 'Which q-theme theme would you like to install?',
                options: [
                    'quasar' => 'quasar',
                    'vuetify' => 'vuetify',
                ]
            ),
        ];
    }

    /**
     * Interact further with the user if they were prompted for missing arguments.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        collect(multiselect(
            label: 'Would you like any optional features?',
            options: collect([
                'locker' => 'Treasury management not yet implemented under programming',
                'expanse' => 'Expenses and budget not yet implemented under programming',
                'client' => 'Customer management not yet implemented under programming',
                'supplier' => 'Supplier management not yet implemented under programming',
                'product' => 'Product management not yet implemented under programming',
            ])->when(
                $input->getArgument('stack') === 'vuetify',
                fn ($options) => $options->put('dark', 'Dark mode')
            )->when(
                $input->getArgument('stack') === 'quasar',
                fn ($options) => $options->put('lang', 'Select Arabic language')
            )->sort()->sort()->all(),
        ))->each(fn ($option) => $input->setOption($option, true));

    }


}
