<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetCssFramework extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'css:set {framework : The name of the framework to set.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the css framework for your project.';

    protected $validFrameworks = [
        'uikit' => [
            'package' => 'uikit'
        ],
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $framework = strtolower($this->argument('framework'));

        if (in_array($framework, ['bs3', 'bootstrap3'])) {
            $this->confirm('The site uses bootstrap 3 as the default.  Would you like to remove the other framework\'s files?');
        }

        if (! in_array($framework, array_keys($this->validFrameworks))) {
            $this->error(
                $framework .' is not a valid framework.  Please select one from the following: '.
                implode(', ', array_keys($this->validFrameworks))
            );
        }

        // Check that command can be run
            // if this has been run before, the extra dirs and files will be absent
        // move resources/assets/sass-framework to sass/
        // remove other one
        // move resources/js/bootstrap-framework.js to boostrap.js
        // remove other one
        // remove other menu blades
        // check for existence of node_modules folder
            // if not there, run yarn
        // run yarn remove for other frameworks
    }
}
