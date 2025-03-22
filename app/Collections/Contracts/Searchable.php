<?php

namespace App\Collections\Contracts;

interface Searchable
{
    public function getSearchProvider();

    public function getSearchParameters();

    public function search($parameters);
}
