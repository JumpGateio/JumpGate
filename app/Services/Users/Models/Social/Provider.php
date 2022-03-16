<?php

namespace App\Services\Users\Models\Social;

class Provider
{
    public string $driver;

    public array $scopes;

    public array $extras;

    public function __construct($details)
    {
        $this->driver = array_get($details, 'driver', null);
        $this->scopes = array_get($details, 'scopes', []);
        $this->extras = array_get($details, 'extras', []);
    }
}
