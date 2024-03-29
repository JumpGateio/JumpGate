<?php

namespace App\Console\Commands\JumpGate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class Telescope extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumpgate:telescope
                            {--remove : Uninstall telescope.  Auto generated files only.}
                            {--f|--force : Remove the config file as well.  Only used with remove.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and set up telescope';

    private Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $remove = $this->option('remove');

        if ($remove) {
            $this->remove();
        } else {
            $this->setup();
        }

        $this->info('Finished!');
    }

    /**
     * Sets up Laravel Telescope in your app.
     *
     * @see https://laravel.com/docs/6.0/telescope
     */
    private function setup()
    {
        $this->comment('Adding telescope to composer...');

        $process = Process::fromShellCommandline(
            'COMPOSER_MEMORY_LIMIT=-1 composer require laravel/telescope'
        );
        $process->setTimeout(150);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        $process->wait();

        $this->comment('Adding telescope files...');
        $process = Process::fromShellCommandline(
            'php artisan telescope:install'
        );
        $process->setTimeout(150);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        $process->wait();

        $this->comment('Running migrations...');
        $this->call('migrate');

        $this->info(
            'Remember, uncomment the telescope entry in app/Http/Composers/Menu.php'
        );
    }

    private function remove()
    {
        $this->comment('Removing service provider...');
        $this->files->delete(app_path('Providers/TelescopeServiceProvider.php'));

        $this->comment('Removing vendor assets...');
        $this->files->deleteDirectory(public_path('vendor/telescope/'));

        $this->comment('Removing database tables...');
        $this->call('migrate:rollback', [
            '--path' => 'vendor/laravel/telescope/database/migrations/2018_08_08_100000_create_telescope_entries_table.php',
        ]);

        $removeConfig = $this->option('force');

        if ($removeConfig) {
            $this->comment('Removing config...');
            $this->files->delete(config_path('telescope.php'));
        }

        $this->comment('Removing from composer...');

        $process = Process::fromShellCommandline(
            'COMPOSER_MEMORY_LIMIT=-1 composer remove laravel/telescope; php artisan optimize'
        );
        $process->setTimeout(150);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        $process->wait();

        $this->info(
            'Remember, you can safely remove any telescope entries from config/app.php and app/Http/Composers/Menu.php'
        );

        $this->warn('The error that may display next can be ignored.');
    }
}
