<?php

namespace App\Services\Users\Models;

use App\Services\Users\Traits\ConvertsToCollection;
use Laratrust\Models\Permission as LaratrustPermission;

class Permission extends LaratrustPermission
{
    use ConvertsToCollection;
}
