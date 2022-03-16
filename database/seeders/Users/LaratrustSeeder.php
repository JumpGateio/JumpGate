<?php

namespace Database\Seeders\Users;

use Database\Seeders\Base;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LaratrustSeeder extends Base
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        $this->truncateLaratrustTables();

        $config         = config('laratrust_seeder.role_structure');
        $mapPermission  = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {

            // Create a new role
            $role        = \JumpGate\Users\Models\Role::create([
                'name'         => $key,
                'display_name' => ucwords(str_replace('_', ' ', $key)),
                'description'  => ucwords(str_replace('_', ' ', $key)),
            ]);
            $permissions = [];

            $this->command->info('Creating Role ' . strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = \JumpGate\Users\Models\Permission::firstOrCreate([
                        'name'         => $permissionValue . '-' . $module,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        'description'  => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ])->id;

                    $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                }
            }

            // Attach all permissions to the role
            $role->permissions()->sync($permissions);

            $this->command->info("Creating '{$key}' user");
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('rbac_permission_role')->truncate();
        DB::table('rbac_permission_user')->truncate();
        DB::table('rbac_role_user')->truncate();
        \JumpGate\Users\Models\Role::truncate();
        \JumpGate\Users\Models\Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
