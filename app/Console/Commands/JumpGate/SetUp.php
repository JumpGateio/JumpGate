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
    protected $signature = 'jumpgate:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do all the initial steps to set up your jumpgate app.';

    private Filesystem $files;

    private bool $generatedEnv = true;

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

        $this->info('Finished!');
    }

    /**
     * Make sure a .env file exists.
     */
    private function generateEnv(): void
    {
        if (! $this->files->exists(base_path('.env'))) {
            $this->comment('Generating .env...');

            $this->files->copy('.env.example', '.env');

            return;
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
        // $this->comment('Publishing docs...');
        // $this->call('vendor:publish', ['--tag' => 'larecipe_assets', '--force' => true]);

        $this->comment('Running yarn...');

        $process = Process::fromShellCommandline('yarn');
        $process->setTimeout(150);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        $process->wait();

        $this->comment('Running laravel mix...');

        $process = Process::fromShellCommandline('npm run dev');
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        // $this->comment('Running laravel docs...');
        // $this->call('larecipe:install');
    }

    /**
     * Discover any packages we will be needing.
     */
    private function discover()
    {
        $this->comment('Running laravel discover...');

        $this->call('package:discover');
    }
}
