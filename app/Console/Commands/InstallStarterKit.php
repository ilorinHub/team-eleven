<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallStarterKit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kit:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the Laravel Starter Kit';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        shell_exec('cp .env.example .env');
        Artisan::call('key:generate');
        $this->info('Starter Kit setup complete!');
        return Command::SUCCESS;
    }
}
