<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Notifications\ResetPasswordLink;
use App\User;
use Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $redirectTo = 'admin/forgotpwd';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * This method is used for view forgot password page.
     *
     * @param none
     * @return HTML
     */
    public function getForgotPassword()
    {
        return view('auth.forgotpwd');
    }

    /**
     * This method is used for reset password purpose.
     *
     * @param Illuminate\Http\Request $request
     * @return HTML
     */
    public function postForgotPassword(Request $request)
    {
        $messages = [
            'forgot_email.required' => trans('admin.dealer_user_email_required'),
            'forgot_email.email' => trans('admin.dealer_user_email_email')
          ];
        $validatedData = $request->validate([
            'forgot_email' => 'required|email'
        ],$messages);

        $email = $request->get('forgot_email');
        $user= User::where('email',$email)->first();
        if(!$user)
        {
            return redirect()->back()
                    ->withErrors([ "emailerror" => trans('admin.dealer_user_email_unique')]);
        }else{
            //  $password = str_random(10);
             $password ='123456'; //for testing
             $user->password_hash = Hash::make($password);
             $user->save();
            //  $fullname = $user->username;
            //  echo $password;exit;
            // $user->notify(new ResetPasswordLink($password,$fullname));
            return redirect()
                    ->intended($this->redirectTo)
                    ->with('message',trans('admin.changed_password')); 
        }
    }
}
