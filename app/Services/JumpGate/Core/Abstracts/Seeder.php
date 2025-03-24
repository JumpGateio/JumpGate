<?php

namespace App\Services\JumpGate\Core\Abstracts;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder as BaseSeeder;

abstract class Seeder extends BaseSeeder
{
    /**
     * @var DatabaseManager
     */
    protected $db;

    public function __construct()
    {
        $this->db = app('db');
    }

    /**
     * Truncate the existing table of all records.
     *
     * @param string $table
     */
    protected function truncate(string $table): void
    {
        if ($this->db->connection()->getConfig('driver') === 'mysql') {
            $this->db->statement('SET FOREIGN_KEY_CHECKS=0;');
            $this->db->table($table)->truncate();
            $this->db->statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
