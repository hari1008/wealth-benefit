<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\MasterEcosystem;

class OnceADayCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onceadaycron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will run once a day a update the system accordingly.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
   
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {     
        Log::info('Everyday Cron is Running');
        MasterEcosystem::checkEcosystemExpiry();
    }   
  
}
