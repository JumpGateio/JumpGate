<?php

namespace App\Console\Commands\JumpGate;

use Illuminate\Console\Command;

class Rbac extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbac';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the role and permission seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', ['--class' => '\Database\Seeders\RBACDatabaseSeeder']);
    }
}
