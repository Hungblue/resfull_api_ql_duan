<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CheckPoint;

class check_point extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CheckPont';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update data check point';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        $today= date('Y-m-d');
        
        $checkPoint = CheckPoint::where('end_date','<', $today)->where('status','<>',5)->get();
        foreach ($checkPoint as $item) {
            $updateCheckPoint = CheckPoint::find($item->id);
            $updateCheckPoint->status = 5;
            $updateCheckPoint->save();
        }
    }
}
