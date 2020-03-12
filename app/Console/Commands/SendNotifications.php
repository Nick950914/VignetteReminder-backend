<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendnotifications';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $reminders = Reminder::whereBetween('due_change_date', [Carbon::now(), Carbon::now()->addDays(5)])->get();

//        foreach ($reminders as $reminder) {
////            if ($reminder->due_change_date > Carbon::now()) {
//                $emailBody = "Dear " . $reminder->user->first_name . " " . $reminder->user->last_name . ",\n" . "\n" . "we are kindly reminding you about your " . $reminder->title . " which expires/should be changed by " . $reminder->due_change_date . ".";
//                Mail::raw("$emailBody", function ($mail) use ($reminder) {
//                    $mail->from('laravelmailtesting1@gmail.com');
//                    $mail->to($reminder->user->email)
//                        ->subject('Gentle Reminder');
//                });
////            }
//        }
//            echo "Dear, " . $reminder->user->first_name . " " . $reminder->user->last_name . ", we are kindly reminding you about your " . $reminder->title . " which expires/should be changed by " . $reminder->due_change_date . ". \n";
    }
}
