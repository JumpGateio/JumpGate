<?php

namespace App\Services\Users\Models;

use App\Services\Users\Traits\ConvertsToCollection;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    use ConvertsToCollection;
}
