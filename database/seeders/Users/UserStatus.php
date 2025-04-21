<?php

namespace Database\Seeders\Users;

use Database\Seeders\Base;

class UserStatus extends Base
{
    public function run()
    {
        $statuses = [
            [
                'name'  => 'active',
                'label' => 'Active',
            ],
            [
                'name'  => 'inactive',
                'label' => 'Inactive',
            ],
            [
                'name'  => 'blocked',
                'label' => 'Blocked',
            ],
        ];

        // Add any data to the table.
        $this->freshSeed('user_statuses', $statuses);
    }
}
