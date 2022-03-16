<?php

namespace Database\Seeders;

use Database\Seeders\Users\DefaultUsers;
use Database\Seeders\Users\LaratrustSeeder;
use Database\Seeders\Users\UserStatus;

class UserDatabaseSeeder extends Base
{
    protected array $seeders = [
        UserStatus::class,
        LaratrustSeeder::class,
        DefaultUsers::class,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runSeeders();
    }
}
