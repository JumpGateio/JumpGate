<?php

namespace App\Console\Commands\JumpGate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Process;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class SetUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jumpgate:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected          $description  = 'Do all the initial steps to set up your jumpgate app.';

    private Filesystem $files;

    private bool       $generatedEnv = true;

    private string     $command;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $hasYarn       = (int)Process::run('yarn -v')->output() > 0;
        $this->command = 'npm';

        if ($hasYarn) {
            $this->command = 'yarn';
        }

        $this->generateEnv();
        $this->generateAppKey();
        $this->handleAssets();
        $this->handleIcons();
        $this->buildFiles();
        $this->discover();

        // Add in request to update config/jumpgate/users.php and .env files
        // Finish set up
            // Migrate, seed, etc

        $this->info('Finished!');
    }

    /**
     * Make sure a .env file exists.
     */
    private function generateEnv(): void
    {
        if (!$this->files->exists(base_path('.env'))) {
            $this->comment('Generating .env...');

            $this->files->copy('.env.example', '.env');

            return;
        }

        $this->generatedEnv = false;
    }

    /**
     * Generate an app key if we made a fresh ,env.
     */
    private function generateAppKey(): void
    {
        if ($this->generatedEnv) {
            $this->comment('Generating app key...');
            $this->call('key:generate');
        }
    }

    /**
     * Run the js and asset compile commands.
     */
    private function handleAssets(): void
    {
        $this->comment('Installing node modules...');

        Process::path(base_path())
            ->timeout(150)
            ->run($this->command . ' install', function ($type, $output) {
                echo $output;
            });
    }

    private function handleIcons(): void
    {
        $fontAwesome = select(
            label: 'Are you going to use font-awesome?',
            options: ['No', 'Pro', 'Free'],
            default: 'Pro'
        );

        // No need to do anything
        if ($fontAwesome == 'No') {
            return;
        }

        $command = $this->command . ' install --save';

        if ($this->command == 'yarn') {
            $command = $this->command . ' add';
        }

        // Add the pro version after getting the api key.
        if ($fontAwesome == 'Pro') {
            $this->installFontAwesomePro($command);
            return;
        }

        $this->info('Installing font-awesome free...');

        // The free version won't install if the font-awesome registry is in .npmrc.
        $this->files->delete(base_path('.npmrc'));

        Process::path(base_path())
            ->timeout(150)
            ->run($command . ' @fortawesome/fontawesome-free', function ($type, $output) {
                echo $output;
            });
    }

    private function installFontAwesomePro($command): void
    {
        $key = text(
            label: 'What is your api-key?',
            required: true,
            hint: 'This will be added to .npmrc'
        );

        $this->info('Generating .npmrc file...');
        $npmrc = $this->files->get(
            dir_style([base_path(), 'app', 'Console', 'Commands', 'JumpGate', 'resources', '.npmrc'])
        );

        // TODO: substr version may not work 100%.  Test the str_replace version.
        // $npmrc = substr($npmrc, 0, -2) . $key;
        $npmrc = str_replace('FONT_AWESOME_KEY', $key, $npmrc);

        $this->files->put(base_path('.npmrc'), $npmrc);

        $this->info('Installing font-awesome pro...');
        Process::path(base_path())
            ->timeout(240)
            ->run($command . ' @fortawesome/fontawesome-pro', function ($type, $output) {
                echo $output;
            });
    }

    private function buildFiles(): void
    {
        $this->comment('Compiling assets...');

        Process::path(base_path())
            ->run('npm run build', function ($type, $output) {
                echo $output;
            });
    }

    /**
     * Discover any packages we will be needing.
     */
    private function discover(): void
    {
        $this->comment('Running laravel discover...');

        $this->call('package:discover');
    }
}
