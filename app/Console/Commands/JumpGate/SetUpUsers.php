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
                            {--socialite: Adds socialite to users.}
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
        $this->discover();
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

        $process = new Process('composer require ' . $packages);
        $process->setTimeout(150);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }

    /**
     * Based on the options set, determine which packages
     * to get from composer during installation.
     *
     * @return string
     */
    private function getPackagesToInstall()
    {
        $packages = 'jumpgate/users';

        $socialite = $this->option('socialite');

        if ($socialite) {
            $packages .= ' laravel/socialite';
        }

        return $packages;
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
     * Publish all files that come with users.
     */
    private function publishUserFiles()
    {
        $this->info('Publishing users files...');
        $forced = $this->option('force');

        $this->call('vendor:publish', [
            '--provider' => 'JumpGate\Users\Providers\UsersServiceProvider',
            '--force'    => $forced,
        ]);
    }
}
