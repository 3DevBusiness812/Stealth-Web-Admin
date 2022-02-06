<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Mail;
use App\Mail\Sendwelcomemail; 

class testController extends Controller
{
   	
	public function setTestMail(){
		#$to_email = "david@stealthbodyfitness.com";
		//send mail to user 
			/*$data = [
				'subject'  => "Welcome To Stealth Premium!" ,
				'fullName' => 'David Agustine',
				'username' => "david@stealthbodyfitness.com",
				'password' => "gameyourcore",
				'body' => ""
			]; */
	
			//Notification::send($users, new sendmail($user));
			#$mail = Mail::to([$to_email])->send(new Sendwelcomemail($data));
			
			//print_r($mail); dd($data);
	}
}
