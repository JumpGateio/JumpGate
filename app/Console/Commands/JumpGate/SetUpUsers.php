<?php

namespace App\Console\Commands\JumpGate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class SetUpUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumpgate:setup-users
                            {--socialite : Adds socialite to users.}
                            {--f|force : Whether to overwrite existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add jumpgate users to your app.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->addUsers();

        $this->info('Finished!');
    }

    /**
     * Add the user package and files if requested.
     */
    private function addUsers()
    {
        $this->addUserPackage();
        $this->publishUserFiles();

        $this->comment('Users have been added.'
            . "\n"
            . 'If you want to add social capability, update configs/jumpgate/users then run'
            . "\n"
            . 'php artisan vendor:publish --provider="JumpGate\Users\Providers\UsersServiceProvider" '
            . 'to generate the extra migrations.');
    }

    /**
     * Add the user package to composer.
     */
    private function addUserPackage()
    {
        $this->info('Adding users to composer...');

        $packages = $this->getPackagesToInstall();

        if ($packages->count() === 0) {
            return $this->comment('Nothing to add');
        }

        $packages->each(function ($package) {
            $this->comment('Installing ' . $package);
            $process = new Process('composer require ' . $package);
            $process->setTimeout(150);
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });
        });
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
            $process = new Process('composer show ' . $package);
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
        $process = new Process('composer dump-autoload');
        $process->run();

        $this->call('vendor:publish', [
            '--provider' => 'JumpGate\Users\Providers\UsersServiceProvider',
            '--force'    => $forced,
        ]);
    }
}
