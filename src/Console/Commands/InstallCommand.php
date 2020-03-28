<?php

namespace M2S\LaravelNuxt\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nuxt:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new nuxt project or setup integration of an existing one';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->addArgument(
            'source',
            InputArgument::REQUIRED,
            'Root folder of the nuxt application',
            resource_path('nuxt')
        );

        $this->addOption('yarn', 'y', InputOption::VALUE_NONE, 'Use yarn package manager');
        $this->addOption('typescript', 't', InputOption::VALUE_NONE, 'Use typescript runtime');
        $this->addOption('cache', 'c', InputOption::VALUE_OPTIONAL, 'Optional caching endpoint (e.g. /api/cache)');
        $this->addOption('no-export', null, InputOption::VALUE_NONE, 'Do not export env variable on build');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $source = base_path($this->argument('source'));

        $this->installNuxtRemote($source);
        $this->installNuxtLocal($source);
        $this->updatePackageJson();
    }

    protected function installNuxtRemote(string $source)
    {
        if (!file_exists($source) || 2 === count(scandir($source))) {
            passthru(
                ($this->option('yarn') ? 'yarn create ' : 'npx create-').'nuxt-app '.$source
            );
        }

        passthru(
            (
                $this->option('yarn')
                    ? 'yarn add --dev --cwd'
                    : 'npm i -D --prefix'
            ).
            " $source ".
            'nuxt-laravel@next @nuxtjs/axios'.
            $this->option('cache') ? ' @nuxtjs/pwa' : ''
        );
    }

    protected function installNuxtLocal(string $source)
    {
        $configFile = base_path('nuxt.config.'.($this->option('typescript') ? 'ts' : 'js'));

        passthru(
            (
                $this->option('yarn')
                    ? 'yarn add --dev '
                    : 'npm i -D '
            ).
            'nuxt'.
            $this->option('typescript') ? ' @nuxt/typescript-runtime' : ''
        );

        $config = view(
            'nuxt::config',
            [
                'source' => $source,
                'prefix' => trim(config('nuxt.prefix'), '/'),
                'cache'  => rtrim($this->option('cache'), '/'),
                'export' => !$this->option('no-export'),
            ]
        )->render();

        file_put_contents($configFile, $config);
    }

    protected function updatePackageJson()
    {
        $packageFile = base_path('package.json');

        $package = json_decode(file_get_contents($packageFile));
        $nuxt = $this->option('typescript') ? 'nuxt-ts' : 'nuxt';

        $package->script->{'nuxt:dev'} = $nuxt;
        $package->script->{'nuxt:build'} = $nuxt.' generate';
        $package->script->{'nuxt:start'} = $nuxt.' start';

        file_put_contents($packageFile, json_encode($package, JSON_PRETTY_PRINT));
    }
}
