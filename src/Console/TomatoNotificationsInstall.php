<?php

namespace Queents\TomatoSettings\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Queents\ConsoleHelpers\Traits\HandleStub;
use Queents\ConsoleHelpers\Traits\RunCommand;

class TomatoNotificationsInstall extends Command
{
    use HandleStub;
    use RunCommand;

    private string $stubPath;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'tomato-settings:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install tomato settings package and publish assets';

    public function __construct()
    {
        parent::__construct();
        $this->publish = __DIR__ .'/../../publish/';
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('🍅 Publish Components Vendor Assets');
        $this->handelFile('/resources/js/app.js', resource_path('/js/app.js'));
        $this->callSilent('optimize:clear');
        $this->call('vendor:publish', ['--provider' => 'Queents\TomatoComponents\TomatoComponentsServiceProvider']);
        $this->yarnCommand(['install']);
        $this->yarnCommand(['build']);
        $this->artisanCommand(["migrate"]);
        $this->artisanCommand(["optimize:clear"]);
        $this->info('🍅 Tomato Components installed successfully.');
    }
}
