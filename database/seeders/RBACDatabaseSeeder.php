<?php

namespace Database\Seeders;

use Database\Seeders\RBAC\Permissions;
use Database\Seeders\RBAC\Roles;

class RBACDatabaseSeeder extends Base
{
    protected array $seeders = [
        Roles::class,
        Permissions::class,
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
