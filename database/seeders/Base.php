<?php

namespace Database\Seeders;

use JumpGate\Core\Abstracts\Seeder;

abstract class Base extends Seeder
{
    protected array $seeders = [];

    public function runSeeders()
    {
        foreach ($this->seeders as $seeder) {
            $this->call($seeder);
        }
    }

    public function seed($table, $data)
    {
        $this->truncate($table);
        $this->db->table($table)->insert($data);
    }
}
