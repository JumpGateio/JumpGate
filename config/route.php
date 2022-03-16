<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route Storage Paths
    |--------------------------------------------------------------------------
    |
    | If you want to use class based routes (instead of the default
    | Laravel flat files) you can declare the directories they
    | should be in here.  The standard JumpGate paths have
    | been included for you.
    |
    */

    'paths' => [
        app_path('Http/Routes'),
        app_path('Services/*/Http/Routes'),
        app_path('Services/*/Http/Routes/*/'),
        app_path('Services/*/Http/Routes/*/*/'),
        base_path('vendor/jumpgate/users/src/JumpGate/Users/Http/Routes')
    ],
];
