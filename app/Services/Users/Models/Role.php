<?php

namespace App\Services\Users\Models;

use App\Services\Users\Traits\ConvertsToCollection;
use Laratrust\Models\Role as LaratrustRole;

class Role extends LaratrustRole
{
    use ConvertsToCollection;
}
