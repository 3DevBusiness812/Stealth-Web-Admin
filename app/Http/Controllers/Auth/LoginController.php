<?php


namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Validations\AdminRequest;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    /**
     * This method is used for Login purpose.
     *
     * @param App\Http\Requests\AdminRequest  $request
     * @return HTML
    */
    public function login(Request $request) {
        
        $email = $request->get('useremail');
        $password =$request->get('password');
        if (Auth::attempt(['email' =>  $email, 'password' => $password]))
        {
           
            return redirect()->intended($this->redirectTo);     
        }else{
            return redirect()
            ->back()
            ->withErrors([ "error" => 'Enter Valid Credentials.']);
        }
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {        
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        
        return redirect('/');
    } 
	
}
