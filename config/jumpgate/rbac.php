<?php

/**
 * All the entries in this file are used when seeding the RBAC tables.
 *
 * @see Database\Seeders\RBAC\Roles
 * @see Database\Seeders\RBAC\Permissions
 *
 * @run php artisan rbac to add new details to DB
 */
return [
    'roles' => [
        [
            'name'         => 'developer',
            'display_name' => 'Developer',
            'description'  => 'Works on maintaining and improving the site.',
        ],
        [
            'name'         => 'admin',
            'display_name' => 'Admin',
            'description'  => 'A user who can administrate the site.',
        ],
    ],
    'permissions' => [
        // ADMIN AREAS
        [
            'name'         => 'access-admin',
            'display_name' => 'Access Admin',
            'description'  => 'Access the admin area.',
            'roles'        => ['developer', 'director'],
        ],
        // ADMIN TOOLS
        [
            'name'         => 'access-pulse',
            'display_name' => 'Access Pulse',
            'description'  => 'Access the pulse dashboard.',
            'roles'        => ['developer', 'director'],
        ],
        [
            'name'         => 'access-telescope',
            'display_name' => 'Access Telescope',
            'description'  => 'Access the telescope dashboard.',
            'roles'        => ['developer', 'director'],
        ],
        // USER CONTROL
        [
            'name'         => 'create-user',
            'display_name' => 'Create New Users',
            'description'  => 'Create users in the admin area.',
            'roles'        => ['developer', 'director'],
        ],
        [
            'name'         => 'update-user',
            'display_name' => 'Update Users',
            'description'  => 'Update users in the admin area.',
            'roles'        => ['developer', 'director'],
        ],
        [
            'name'         => 'delete-user',
            'display_name' => 'Delete Users',
            'description'  => 'Delete users in the admin area.',
            'roles'        => ['developer', 'director'],
        ],
        //RBAC CONTROL
        [
            'name'         => 'manage-roles',
            'display_name' => 'Manage Roles',
            'description'  => 'Add/Remove permissions from roles.',
            'roles'        => ['developer', 'director'],
        ],
        // STATUS CONTROL
        [
            'name'         => 'create-status',
            'display_name' => 'Create New User Status',
            'description'  => 'Create user statuses in the admin area.',
            'roles'        => ['developer', 'director'],
        ],
        [
            'name'         => 'update-status',
            'display_name' => 'Update User Status',
            'description'  => 'Update user statuses in the admin area.',
            'roles'        => ['developer', 'director'],
        ],
        [
            'name'         => 'delete-status',
            'display_name' => 'Delete User Status',
            'description'  => 'Delete user statuses in the admin area.',
            'roles'        => ['developer', 'director'],
        ],
    ]
];
