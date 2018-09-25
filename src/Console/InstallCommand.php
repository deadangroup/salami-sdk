<?php

namespace Deadan\Support\Console;

use Deadan\Admin\Installer\Setup;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates some default plans, roles and admin user to get things going';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $installer = app(Setup::class);
        $installer->roles();
        $installer->plans();
        $installer->admin();
    }
}
