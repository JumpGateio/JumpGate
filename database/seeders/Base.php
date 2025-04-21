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

    /**
     * @param string         $table
     * @param mixed          $data
     * @param boolean|string $columnCheck
     *
     * @return void
     */
    public function seed(string $table, mixed $data, bool|string $columnCheck = false): void
    {
        if (!$columnCheck) {
            $this->db->table($table)->insert($data);

            return;
        }

        $existingRecords = $this->db->table($table)
            ->whereIn($columnCheck, array_column($data, $columnCheck))
            ->pluck($columnCheck)
            ->all();

        // Filter out existing ones
        $newData = array_filter($data, fn($item) => !in_array($item[$columnCheck], $existingRecords));

        // Insert only the new ones
        $this->db->table($table)->insert($newData);
    }

    /**
     * @param string $table
     * @param mixed  $data
     *
     * @return void
     */
    public function freshSeed(string $table, mixed $data): void
    {
        $this->truncate($table);
        $this->db->table($table)->insert($data);
    }
}
