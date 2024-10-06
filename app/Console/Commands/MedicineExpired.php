<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Caliber;
use Carbon\Carbon;

class MedicineExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medicine_expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check medicines every day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now=Carbon::now()->addDays(2);
        $n=$now->toDateString();
        $calibers=Caliber::get();
        foreach($calibers as $caliber){
            $ex=$caliber->expiration_date;
            if($ex<=$n)
            $caliber->update(['status'=>false]);
        }
    }
}
