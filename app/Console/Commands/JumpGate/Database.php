<?php

namespace App\Console\Commands\JumpGate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class Database extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumpgate:database
                            {--no-fresh : Will just run migrate instead of migrate:fresh}
                            {--no-seed : Will skip the seed command.}
                            {--users : Will run the user database seeder.}
                            {--f|--force : Will force this to run even in production mode.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations and seeders.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $forced = $this->option('force');

        if (app()->environment('production') && ! $forced) {
            $this->error('You cannot run this command in production without --force.');
            die;
        }

        $this->runMigrations();
        $this->runSeeders();

        $this->info('Finished!');
    }

    /**
     * Run the migrations.
     */
    private function runMigrations()
    {
        $fresh   = $this->option('no-fresh') == null;
        $command = 'migrate';
        $message = 'Migrating database';

        if ($fresh) {
            $command .= ':fresh';
            $message .= ' with fresh tables';
        }

        $this->info($message . '...');

        $this->call($command);
    }

    /**
     * Run the seeds.
     */
    private function runSeeders()
    {
        $noSeedersFlag = $this->option('no-seed');
        $usersFlag     = $this->option('users');

        if ($noSeedersFlag) {
            $this->info('No-seed flag added.  Skipping seeders.');

            return;
        }

        $this->info('Running seeders...');

        $this->call('db:seed');

        if ($usersFlag) {
            $this->call('db:seed', ['--file' => 'Database\Seeders\UserDatabaseSeeder']);
        }
    }
}
