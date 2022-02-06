<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;

use App\Mail\Sendwelcomemail; 
use DB; 
use Mail;

class updatePremiumSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users; 
	/**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subscribedUsers)
    {
        $this->users = $subscribedUsers; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $subscribedData = $this->users;
		 $subscribedData['email'] = trim($subscribedData['email']);
		 $to_email = $subscribedData['email'];
		 if($subscribedData['exist']){ 
			
			$userData = DB::table("accounts")->select('id')->where("email", $subscribedData['email'])->first();
			$userId = isset($userData->id) ? $userData->id : '0';
			
			DB::table('premium_users')->insert(
				['user_id'=> $userId, 'email' => $subscribedData['email'], 'start_date' => date('Y-m-d H:i:s'), 'end_date'=>date('Y-m-d H:i:s', strtotime('+1 year'))]
			);
			
			//send mail to user
			
			$data = [
				'subject' => trans('admin.welcome_subj') ,
				'fullName' => $subscribedData['fname'].' '.$subscribedData['lname'],
				'username' =>  $subscribedData['email'],
				'password' => '',
				'body' => trans('admin.body_exist_user')
			];
	
			//Notification::send($users, new sendmail($user));
			Mail::to([$to_email])->send(new Sendwelcomemail($data));
			
		 }else{ 
			$userId = sha1(time()).'-'.rand(0,1000).Str::random(8);
			//New User, insert into accounts table and 
			DB::table('accounts')->insert(
				['id'=> $userId, 'email' => $subscribedData['email'], 'password_hash' => '$2a$10$12heg8aFqdXox5HJ1EcY3O7u0oUAGMuHkNd6gJKezst9cPNBmOTqa', 'firstname'=>$subscribedData['fname'], 'lastname'=>$subscribedData['lname'], 'access_token'=>sha1(time()).'-'.Str::random(5), 'is_firstlogin'=>1]
			);
			
 
			DB::table('premium_users')->insert(
				['user_id'=> $userId,'email' => $subscribedData['email'], 'start_date' => date('Y-m-d H:i:s'), 'end_date'=>date('Y-m-d H:i:s', strtotime('+1 year'))]
			);
						
			//send mail to user 
			$data = [
				'subject'  => trans('admin.welcome_subj') ,
				'fullName' => $subscribedData['fname'].' '.$subscribedData['lname'],
				'username' => $subscribedData['email'],
				'password' => trans('admin.password'),
				'body' => trans('admin.body_new_user')
			];
	
			//Notification::send($users, new sendmail($user));
			Mail::to([$to_email])->send(new Sendwelcomemail($data));
		 }
    }
}
