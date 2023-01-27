<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Isolatable;

class DeployApplication extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kit:deploy {--C|clean}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs deployment optimizations in production';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ( !App::environment('staging', 'production') ) {
            $this->error('Deploy only runs in staging and production environments!');

            return Command::FAILURE;
        }
        // [

        // ]
        if ( $this->option('clean') ) {
            $this->withProgressBar(1, fn() => Artisan::call('migrate:fresh --seed'));
        }

        // $this->withProgressBar(fn() => shell_exec('composer install --optimize-autoloader --no-dev'));

        // Artisan::call('optimize:clear');

        // Artisan::call('optimize');

        // Artisan::call('view:cache');

        // Artisan::call('event:cache');

        // Artisan::call('page-cache:clear');

        // $this->info('Deployment optimizations complete!');

        return Command::SUCCESS;
    }
}
