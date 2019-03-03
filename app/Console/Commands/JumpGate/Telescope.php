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
    protected $signature = 'jumpgate:telescope';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup telescope';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    /**
     * @var bool
     */
    private $generatedEnv = true;

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
        $this->setupTelescope();

        $this->info('Finished!');
    }

    /**
     * Sets up Laravel Telescope in your app.
     *
     * @see https://laravel.com/docs/5.7/telescope
     */
    private function setupTelescope()
    {
        $addTelescope = $this->option('telescope');

        if (!$addTelescope) {
            return true;
        }

        $this->call('telescope:install');
        $this->call('package:discover');
        $this->call('migrate');
    }
}
