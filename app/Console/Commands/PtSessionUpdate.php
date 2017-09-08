<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\UserBooking;
use Illuminate\Support\Facades\Log;

class PtSessionUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptsessionupdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update goal and PT session information once booking time is over.';

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
        Log::info('Every min Cron is Running');
        UserBooking::cronUpdateGoalAndPtBooking();
    }   
  
}
