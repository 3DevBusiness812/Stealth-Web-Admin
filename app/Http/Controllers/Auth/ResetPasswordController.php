<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Hash;
use App\Http\Validations\ChangePasswordValidations;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = 'admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * This method is used for change password  
     * 
     * @param App\Http\Requests\ChangePasswordValidations $request
     * @return JSON response
     */	
    public function changePwd(ChangePasswordValidations $request)
    {
        
        $updatePasswordArray = array(
            'pswd'	=> Hash::make($request['newPassword']),
        );
        $adminId = $request['adminId'];
        $changePwd = User::where('id',$adminId)
                         ->update($updatePasswordArray);

        if ($changePwd) {
            $message = trans('admin.changed_password');
            return (['success' => true, 'message' => $message, 'redirect' => true, 'url' => '/usersList']);
        } else {
            $message = trans('admin.changed_password_err');
            return (['success' => false, 'message' => $message, 'redirect' => false, 'url' => '']);
        }
    }
}
