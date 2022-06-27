<?php

namespace App\Console\Commands;

use App\Models\EmailRemind;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class auto_send_mail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auto_send_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $arrName = [];
        $user = User::whereMonth('birthday', '=', date('m'))->whereDay('birthday', '=', date('d'))->get();
        foreach ($user as $user) {
            $name = $user->name;
            array_push($arrName, $name);
        }
        $email_Nhac_nho = EmailRemind::all();
        foreach ($email_Nhac_nho as $item) {
            foreach ($arrName as $name) {
                $to_email = $item->email;
                $to_name =  $item->email;
                $data = array('name' => 'Hello', 'body' => 'Hôm nay là sinh nhật của bạn : ' . $name);
                Mail::send('emails.mail', $data, function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)->subject('Nhắc nhở sinh nhật');
                    $message->from('info@miraisoft.com.vn', 'Nhắc nhở sinh nhật');
                });
            }
        }
    }
}
