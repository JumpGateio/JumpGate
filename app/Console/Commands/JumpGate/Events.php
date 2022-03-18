<?php

namespace App\Console\Commands\JumpGate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class Events extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumpgate:events
                            {--remove : Uninstall telescope.  Auto generated files only.}
                            {--f|--force : Remove the config file as well.  Only used with remove.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and set up laravel websockets';

    private Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
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
     * Sets up Laravel Websockets in your app.
     *
     * @see https://beyondco.de/docs/laravel-websockets/getting-started/introduction
     */
    private function setup()
    {
        $this->comment('Adding websockets to composer...');

        $process = Process::fromShellCommandline(
            'COMPOSER_MEMORY_LIMIT=-1 composer require beyondcode/laravel-websockets'
        );
        $process->setTimeout(150);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        $process->wait();

        $this->comment('Adding websockets migration...');

        $process = Process::fromShellCommandline(
            'php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"'
        );
        $process->setTimeout(150);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        $process->wait();

        $this->comment('Running migrations...');
        $this->call('migrate');

        $this->comment(
            'Remember:'
        );
        $this->info(
            'Uncomment the websocket entry in app/Http/Composers/Menu.php'
        );
        $this->info(
            'Uncomment the BroadcastServiceProvider in config/app.php'
        );
    }

    private function remove()
    {
        $this->comment('Removing vendor assets...');
        $this->files->deleteDirectory(public_path('vendor/telescope/'));

        $this->comment('Removing database tables...');
        $migrationFile = 'database/migrations/0000_00_00_000000_create_websockets_statistics_entries_table.php';

        $this->call('migrate:rollback', [
            '--path' => $migrationFile,
        ]);
        $this->files->delete(base_path($migrationFile));

        $removeConfig = $this->option('force');

        if ($removeConfig) {
            $this->comment('Removing config...');
            $this->files->delete(config_path('websockets.php'));
        }

        $this->comment('Removing from composer...');

        $process = Process::fromShellCommandline(
            'COMPOSER_MEMORY_LIMIT=-1 composer remove beyondcode/laravel-websockets; php artisan optimize'
        );
        $process->setTimeout(150);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        $process->wait();

        $this->info(
            'Remember, you can safely remove any websocket entries from app/Http/Composers/Menu.php'
        );

        $this->warn('The error that may display next can be ignored.');
    }
}
