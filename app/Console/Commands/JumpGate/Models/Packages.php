<?php

namespace App\Console\Commands\JumpGate\Models;

use JumpGate\Database\Collections\SupportCollection;

class Packages
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var SupportCollection
     */
    public $add;

    /**
     * @var SupportCollection
     */
    public $remove;

    public function __construct($type)
    {
        $this->type   = $type;
        $this->add    = supportCollector();
        $this->remove = supportCollector();
    }
}
