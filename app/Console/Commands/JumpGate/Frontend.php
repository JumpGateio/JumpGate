<?php

namespace App\Console\Commands\JumpGate;

use App\Console\Commands\JumpGate\Models\Css;
use App\Console\Commands\JumpGate\Models\Js;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Frontend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumpgate:frontend
                            {css? : The name of the css framework to set.}
                            {js? : JS options (default, inertia).}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the css framework and JS for your project.';

    /**
     * @var Css
     */
    protected $css;

    /**
     * @var Js
     */
    protected $js;

    public function __construct()
    {
        parent::__construct();

        $this->css = new Css;
        $this->js  = new Js;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setUpCss();
        $this->setUpJs();

        $this->moveFiles();
        $this->removeDependencies();
        $this->addDependencies();
        $this->runWebpack();
        $this->clearViews();

        $this->info('Finished!');
    }

    protected function setUpCss()
    {
        $framework = $this->getFrameworkName();
        $message   = $this->css->setActiveFramework($framework);
        $this->css->setPackages();

        $this->info($message);
    }

    protected function setUpJs()
    {
        $js      = $this->getJs();
        $message = $this->js->setOption($js);
        $this->js->setPackages();

        $this->info($message);
    }

    /**
     * Try to get a valid framework name from the user's input.
     *
     * @return array|string
     */
    private function getFrameworkName()
    {
        $framework = $this->argument('css');

        if (is_null($framework)) {
            $framework = $this->listOptions();
        }

        while (!$this->css->validateFramework($framework)) {
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
        return $this->choice('Which framework would you like to use?', array_keys($this->css->validFrameworks), 0);
    }

    /**
     * Try to get a valid framework name from the user's input.
     *
     * @return array|string
     */
    private function getJs()
    {
        $option = $this->argument('js');

        if (is_null($option)) {
            $option = $this->listJsOptions();
        }

        while (!$this->js->validateOption($option)) {
            $this->error($option . ' is not a valid option.');
            $option = $this->listOptions();
        }

        return $option;
    }

    /**
     * Display a list of the currently available JS options.
     *
     * @return string
     */
    private function listJsOptions()
    {
        return $this->choice('Which JS option would you like to use?', array_keys($this->js->validOptions), 0);
    }

    /**
     * Delete non-bootstrap files.  (Views, includes, etc).
     */
    private function moveFiles()
    {
        $this->comment('Copying files...');

        $this->css->moveFiles();
    }

    /**
     * Remove any dependencies.
     */
    private function removeDependencies()
    {
        $this->comment('Removing JS dependencies...');

        $removeJs = supportCollector();
        $removeJs = $removeJs->merge($this->css->packages->remove);
        $removeJs = $removeJs->merge($this->js->jsPackages->remove);

        $removeJs->each(function ($package) {
            $process = new Process('yarn remove ' . $package);
            $process->run();
        });

        $this->comment('Removing composer dependencies...');

        $this->js->phpPackages->remove->each(function ($package) {
            $process = new Process('composer remove ' . $package);
            $process->run();
        });
    }

    /**
     * Add any dependencies.
     */
    private function addDependencies()
    {
        $this->comment('Adding JS dependencies...');

        $addJs = supportCollector();
        $addJs = $addJs->merge($this->css->packages->add);
        $addJs = $addJs->merge($this->js->jsPackages->add);

        $addJs->each(function ($package) {
            $process = new Process('yarn add ' . $package);
            $process->run();
        });

        $this->comment('Adding composer dependencies...');

        $this->js->phpPackages->add->each(function ($package) {
            $process = new Process('composer require ' . $package);
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
}
