<?php

namespace App\Console\Commands\JumpGate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class SetCssFramework extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumpgate:css 
                            {framework? : The name of the framework to set.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the css framework for your project.';

    /**
     * @var string
     */
    protected $framework;

    protected $validFrameworks = [
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

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $framework = $this->getFrameworkName();

        $this->setActiveFramework($framework);

        $this->moveFiles();
        $this->removeDependencies();
        $this->addDependencies();
        $this->runWebpack();
        $this->clearViews();

        $this->info('Finished!');
    }

    /**
     * Try to get a valid framework name from the user's input.
     *
     * @return array|string
     */
    private function getFrameworkName()
    {
        $framework = $this->argument('framework');

        if (is_null($framework)) {
            $framework = $this->listOptions();
        }

        while (!in_array($framework, array_keys($this->validFrameworks))) {
            $this->error($framework . ' is not a valid framework.');
            $framework = $this->listOptions();
        }

        return $framework;
    }

    /**
     * Display a list of the currently available frameworks.
     *
     * @return string
     */
    private function listOptions()
    {
        return $this->choice('Which framework would you like to use?', array_keys($this->validFrameworks), 0);
    }

    /**
     * Assign the selected framework to the object.
     *
     * @param string $framework
     *
     * @return string
     */
    private function setActiveFramework($framework)
    {
        switch (strtolower($framework)) {
            case 'bs3':
            case 'bootstrap3':
                $this->info('Framework set to bootstrap3...');

                return $this->framework = 'bootstrap3';
            case 'bs4':
            case 'bootstrap4':
                $this->info('Framework set to bootstrap4...');

                return $this->framework = 'bootstrap4';
            case 'uikit':
                $this->info('Framework set to uikit...');

                return $this->framework = 'uikit';
        }

        throw new \InvalidArgumentException('No CSS framework matching \'' . $framework . '\' was found.');
    }

    /**
     * Delete non-bootstrap files.  (Views, includes, etc).
     */
    private function moveFiles()
    {
        $this->comment('Copying files...');

        $this->files->copyDirectory(__DIR__ . 'resources/' . $this->framework, resource_path());
    }

    /**
     * Remove any dependencies.
     */
    private function removeDependencies()
    {
        $this->comment('Removing JS dependencies...');

        $this->getOtherFrameworkDetails('package')
            ->each(function ($package) {
                $process = new Process('yarn remove ' . $package);
                $process->run();
            });
    }

    /**
     * Add any dependencies.
     */
    private function addDependencies()
    {
        $this->comment('Removing JS dependencies...');

        $this->getFrameworkDetails('package')
            ->each(function ($package) {
                $process = new Process('yarn add ' . $package);
                $process->run();
            });
    }

    /**
     * Run webpack to update the assets.
     */
    private function runWebpack()
    {
        $this->comment('Running webpack...');

        $process = new Process('npm run dev');
        $process->run();
    }

    /**
     * Clear the view cache so the new view resolves.
     */
    private function clearViews()
    {
        $this->comment('Clearing view cache...');

        $process = new Process('php artisan view:clear');
        $process->run();
    }

    /**
     * Get details from the non-selected frameworks.
     *
     * @param string $key
     *
     * @return \JumpGate\Database\Collections\SupportCollection
     */
    private function getOtherFrameworkDetails($key)
    {
        return supportCollector($this->validFrameworks)
            ->forget($this->framework)
            ->flatMap(function ($framework) use ($key) {
                return (array)array_get($framework, $key);
            });
    }

    /**
     * Get details from the selected framework.
     *
     * @param string $key
     *
     * @return \JumpGate\Database\Collections\SupportCollection
     */
    private function getFrameworkDetails($key)
    {
        return supportCollector($this->validFrameworks[$this->framework][$key]);
    }
}
