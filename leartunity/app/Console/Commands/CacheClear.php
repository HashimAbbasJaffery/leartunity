<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CacheClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the cache daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call("cache:clear");
    }
}
