<?php

namespace App\Console\Commands\JumpGate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class SetUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumpgate:setup
                            {--users : Whether the user package should be included.}
                            {--f|force : Whether to overwrite existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do all the initial steps to set up your jumpgate app.';

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
        $this->generateEnv();
        $this->generateAppKey();
        $this->handleAssets();
        $this->discover();

        $this->addUsers();

        $this->info('Finished!');
    }

    /**
     * Make sure a .env file exists.
     */
    private function generateEnv()
    {
        if (!$this->files->exists(base_path('.env'))) {
            $this->comment('Generating .env...');

            $process = new Process('cp .env.example .env');
            $process->run();

            return true;
        }

        $this->generatedEnv = false;
    }

    /**
     * Generate an app key if we made a fresh ,env.
     */
    private function generateAppKey()
    {
        if ($this->generatedEnv) {
            $this->comment('Generating app key...');
            $this->call('key:generate');
        }
    }

    /**
     * Run the js and asset compile commands.
     */
    private function handleAssets()
    {
        $this->comment('Running yarn...');

        $process = new Process('yarn');
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        $process->wait();

        $this->comment('Running laravel mix...');

        $process = new Process('npm run dev');
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        $this->comment('Running laravel docs...');

        $this->call('larecipe:install');
    }

    /**
     * Discover any packages we will be needing.
     */
    private function discover()
    {
        $this->comment('Running laravel discover...');

        $this->call('package:discover');
    }

    /**
     * Add the user package and files if requested.
     */
    private function addUsers()
    {
        $addUsers = $this->option('users');
        $forced   = $this->option('force');

        if (!$addUsers) {
            return true;
        }

        $this->call('jumpgate:setup-users', ['--force' => $forced]);
    }
}
