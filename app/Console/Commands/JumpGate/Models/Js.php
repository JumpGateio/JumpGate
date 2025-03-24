<?php

namespace App\Console\Commands\JumpGate\Models;

use App\Services\JumpGate\Core\Collections\SupportCollection;

class Js
{
    /**
     * @var string
     */
    public $option = null;

    /**
     * @var SupportCollection
     */
    public $jsPackages;

    /**
     * @var SupportCollection
     */
    public $phpPackages;

    /**
     * @var \string[][]
     */
    public $validOptions = [
        'none'    => [
            'composer' => [],
            'package' => [],
        ],
        'inertia' => [
            'composer' => [
                'inertiajs/inertia-laravel',
                'tightenco/ziggy',
            ],
            'package'  => [
                '@inertiajs/inertia',
                '@inertiajs/inertia-vue',
            ],
        ],
    ];

    public function __construct()
    {
        $this->jsPackages  = new Packages('js');
        $this->phpPackages = new Packages('php');
    }

    /**
     * Determine if the selected option is one of the valid choices.
     *
     * @param string $option
     *
     * @return bool
     */
    public function validateOption($option)
    {
        return in_array($option, array_keys($this->validOptions));
    }

    /**
     * Assign the selected option to the object.
     *
     * @param string $option
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function setOption($option)
    {
        switch (strtolower($option)) {
            case 'none':
                $name = 'Default JS';
                $this->option = 'none';
                break;
            case 'inertia':
                $name = 'Inertia JS';
                $this->option = 'inertia';
                break;
        }

        if (!is_null($this->option)) {
            return $name . ' set up selected...';
        }

        throw new \InvalidArgumentException('No JS option matching \'' . $option . '\' was found.');
    }

    /**
     * Set up the packages we need to add and remove.
     */
    public function setPackages()
    {
        $add = $this->validOptions[$this->option];

        foreach ($add['package'] as $item) {
            $this->jsPackages->add->push($item);
        }

        foreach ($add['composer'] as $item) {
            $this->phpPackages->add->push($item);
        }

        supportCollector($this->validOptions)
            ->forget($this->option)
            ->each(function ($option) {
                foreach ($option['package'] as $item) {
                    $this->jsPackages->remove->push($item);
                }
                foreach ($option['composer'] as $item) {
                    $this->phpPackages->remove->push($item);
                }
            });
    }
}
