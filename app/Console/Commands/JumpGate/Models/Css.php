<?php

namespace App\Console\Commands\JumpGate\Models;

use App\Services\JumpGate\Core\Collections\SupportCollection;

class Css
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    /**
     * @var string
     */
    public $framework = null;

    /**
     * @var SupportCollection
     */
    public $packages;

    /**
     * @var \string[][]
     */
    public $validFrameworks = [
        'bootstrap3' => [
            'package' => 'bootstrap-sass',
        ],
        'bootstrap4' => [
            'package' => 'bootstrap',
        ],
        'uikit'      => [
            'package' => 'uikit',
        ],
    ];

    public function __construct()
    {
        $this->files    = app('files');
        $this->packages = new Packages('js');
    }

    /**
     * Try to get a valid framework name from the user's input.
     *
     * @param string $framework
     *
     * @return bool
     */
    public function validateFramework($framework)
    {
        return in_array($framework, array_keys($this->validFrameworks));
    }

    /**
     * Assign the selected framework to the object.
     *
     * @param string $framework
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function setActiveFramework($framework)
    {
        switch (strtolower($framework)) {
            case 'bs3':
            case 'bootstrap3':
                $this->framework = 'bootstrap3';
                break;
            case 'bs4':
            case 'bootstrap4':
                $this->framework = 'bootstrap4';
                break;
            case 'uikit':
                $this->framework = 'uikit';
                break;
        }

        if (!is_null($this->framework)) {
            return 'CSS framework set to ' . $this->framework . '...';
        }

        throw new \InvalidArgumentException('No CSS framework matching \'' . $framework . '\' was found.');
    }

    /**
     * Set up the packages we need to add and remove.
     */
    public function setPackages()
    {
        $this->packages->add->push($this->validFrameworks[$this->framework]['package']);

        supportCollector($this->validFrameworks)
            ->forget($this->framework)
            ->each(function ($framework) {
                $this->packages->remove->push(array_get($framework, 'package'));
            });
    }

    /**
     * Move the specific CSS files to the resource directory of the app.
     */
    public function moveFiles()
    {
        $this->files->copyDirectory(__DIR__ . '/../resources/' . $this->framework, resource_path());
    }
}
