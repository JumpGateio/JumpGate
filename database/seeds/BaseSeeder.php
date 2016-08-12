<?php

abstract class BaseSeeder extends \Illuminate\Database\Seeder
{
    protected function truncate($table)
    {
        if (DB::connection()->getConfig('driver') === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table($table)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
