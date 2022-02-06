<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accounts;
use App\PremiumUsers;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\Sendwelcomemail;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;

class ResetUserPasswordController extends Controller
{
    //
    public function index($id){

		$accounts_count = Accounts::where('password_reset_token','=',$id)->where('is_deleted','=',0)->count();

		if($accounts_count == 0)
		{
			$msg = "Invalid token.";

            Session::flash('error_message', $msg);
            return redirect('reset_password_result');
		}

    	return view('userResetPassword.password_reset')->with('token', $id);;

    }

    public function update_password(Request $request){


        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'confirm_password' => 'required',
            'token' => 'required',
        ]);

        if ($validator->fails()) {

        	$msg = "Please fill both password and confirm password fields";

            Session::flash('error_message', $msg);
            return redirect('reset_password_result');

        }
        else{

        	if($request->input('password') == $request->input('confirm_password'))
        	{
        		$token = $request->input('token');

        		$password = $request->input('password');

				$accounts_count = Accounts::where('password_reset_token','=',$token)->where('is_deleted','=',0)->count();
    			
    			if($accounts_count > 0)
				{

    				$accounts = Accounts::where('password_reset_token','=',$token)->where('is_deleted','=',0)->first();
    				$passwordHash = Hash::make($password);
    				$accounts->password_hash = $passwordHash;
    				$accounts->password_reset_token = NULL;
    				$accounts->save();
    				$msg = "Your password has been reset successfully, Please login to your account with the new password.";

	                Session::flash('message', $msg);
	                return redirect('reset_password_result');

				}
				else{

    				$msg = "Invalid token.";

	                Session::flash('error_message', $msg);
	                return redirect('reset_password_result');

				}

        	}
        	else
    		{

        		$msg = "Both password and confirm password fields must be same";


                Session::flash('error_message', $msg);
                return redirect('reset_password_result');

    		}

        }

	    exit(0);

    }

    public function reset_password_success()
    {
    	return view('userResetPassword.reset_password_success');
    }

    public function resend_faild_mail_bkp(){

    		$start_date = '2020-10-10';

			$localFileName = 'BACKUP_PREMYEAR_1602324001__20201010.csv';

			$data = Excel::load('storage/resendFailedMails13_10_2020/'.$localFileName, function($reader) { 
				$reader->noHeading();
			})->get();


			foreach($data as $datas)
			{

				$name = $datas[0];

				$email = $datas[1];

				$i = 1;

				$accounts_count = Accounts::where('email', '=', $email)->where('is_deleted', '=', 0)->count();

				if($accounts_count > 0)
				{

					$premium_users_count = PremiumUsers::where('email', '=', $email)->whereDate('start_date', '>=', $start_date)->count();

					if($premium_users_count > 0)
					{

						$accounts = Accounts::where('email', '=', $email)->where('is_deleted', '=', 0)->first();
						$first_login = $accounts->is_firstlogin;

						if($first_login == 1)
						{
							// New user //

							$data = [
								'subject'  => trans('admin.welcome_subj') ,
								'fullName' => $name,
								'username' => $email,
								'password' => trans('admin.password'),
								'body' => trans('admin.body_new_user')
							];
					
							//Notification::send($users, new sendmail($user));
							// Mail::to([$email])->send(new Sendwelcomemail($data));

							echo "<br>first login====".$i."========".$email."===============<br>";

						}
						else
						{

							// Exising user //

							$data = [
								'subject' => trans('admin.welcome_subj') ,
								'fullName' => $name,
								'username' =>  $email,
								'password' => '',
								'body' => trans('admin.body_exist_user')
							];
					
							// Mail::to([$email])->send(new Sendwelcomemail($data));

							echo "<br>existing user====".$i."========".$email."===============<br>";

						}

					}

				}

				$i = $i+1;

			}

			echo "======================Completed====================";
			exit(0);

    }

}
