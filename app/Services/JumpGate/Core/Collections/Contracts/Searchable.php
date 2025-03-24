<?php

namespace App\Services\JumpGate\Core\Collections\Contracts;

interface Searchable
{
    public function getSearchProvider();

    public function getSearchParameters();

    public function search($parameters);
}
