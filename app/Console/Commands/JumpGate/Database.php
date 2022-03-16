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
                            {--no-seed: Will skip the seed command.}
                            {-f|--force: Will force this to run even in production mode.}';

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
        $noSeedersFlag   = $this->option('no-seed');

        if ($noSeedersFlag) {
            $this->info('No-seed flag added.  Skipping seeders.');
            return;
        }

        $this->info('Running seeders...');

        $this->call('db:seed');
    }

    /**
     * Based on the options set, determine which packages
     * to get from composer during installation.
     *
     * @return \JumpGate\Database\Collections\SupportCollection
     */
    private function getPackagesToInstall()
    {
        $packages = supportCollector('jumpgate/users');

        $socialite = $this->option('socialite');

        if ($socialite) {
            $packages->push('laravel/socialite');
        }

        return $packages->filter(function ($package) {
            $process = Process::fromShellCommandline('COMPOSER_MEMORY_LIMIT=-1 composer show ' . $package);
            $process->run();

            return ! $process->isSuccessful();
        });
    }

    /**
     * Publish all files that come with users.
     */
    private function publishUserFiles()
    {
        $this->info('Publishing users files...');
        $forced = $this->option('force');

        // On initial run, it may not find the user provider without this.
        $process = Process::fromShellCommandline('COMPOSER_MEMORY_LIMIT=-1 composer dumpauto');
        $process->run();

        // TODO: Provider has been removed.
        $this->call('vendor:publish', [
            '--provider' => 'JumpGate\Users\Providers\UsersServiceProvider',
            '--force'    => $forced,
        ]);
    }

    /**
     * Make sure they have updated the config before continuing.
     */
    private function verifyConfig()
    {
        $updated = $this->confirm('Have you updated your config/jumpgate/users.php config?');

        if (! $updated) {
            $this->comment('Please update your config/jumpgate/users.php config.');

            return $this->verifyConfig();
        }
    }

    /**
     * Finish off the user setup.
     */
    private function finalizeUsers()
    {
        $this->info('Re-publishing users files without force...');

        // Run publish in case social features were turned on.
        // TODO: Provider has been removed.
        $this->call('vendor:publish', [
            '--provider' => 'JumpGate\Users\Providers\UsersServiceProvider',
        ]);

        // Make sure any new files are recognized.
        $process = Process::fromShellCommandline('COMPOSER_MEMORY_LIMIT=-1 composer dumpauto');
        $process->run();

        $this->info('Seeding the user tables...');
        $this->call('db:seed', ['--class' => \Database\Seeders\UserDatabaseSeeder::class]);
    }
}
