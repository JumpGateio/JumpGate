<?php

namespace Database\Seeders\RBAC;

use Database\Seeders\Base;

class Roles extends Base
{
    public function run()
    {
        $this->seed('rbac_roles', config('jumpgate.rbac.roles'), 'name');
    }
}
