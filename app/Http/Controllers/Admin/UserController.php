<?php
/**
 * @file   UserController.php
 * dashboard- users listing, normal/premium edit and settings are included in this page,.
 * @author ZCO Engineer
 * @date   January, 2020
 *
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Accounts;
use App\PremiumUsers;
use DataTables;
use DB;
use Hash;
use Auth;
use Validator;
use Session;
use Illuminate\Support\Str;
use App\Mail\Sendwelcomemail;
use Mail;
use App\Mail\WelcomeMailClass;

class UserController extends Controller
{
   
   /**
     * Display dashboad page with users count.
     * 
     * @param none
     * @return @view
     */
    public function dashboard(Accounts $Accounts, PremiumUsers $PremiumUsers)
    {  
        $arr_normal_count = $Accounts->getNormalUsersCount();
        $arr_premium_count = $PremiumUsers->getPremiumUsersCount();        
        $data['normal_count'] = $arr_normal_count->count;
        $data['premium_count'] = $arr_premium_count->count;        
        return view('dashboard.dashboard', $data);
    }
   
   /**
     * Display a listing of the premium users.
     * 
     * @param none
     * @return @view
     */
    public function premiumUsersList()
    {  
        return view('users.premiumUsers');
    }

    /**
     * Get on Premium Users List.
     * @return \Illuminate\Http\Response
     */
    public function premiumUsersListDt(PremiumUsers $PremiumUsers, Request $request)
    {
        $searchString = $request->get('searchData');
        $get_users = $PremiumUsers->getPremiumUsersListDt();
        return Datatables::of($get_users)
                ->filter(function ($query) use ($searchString) {
                if ($searchString) {                        
                    $query->whereRaw('(a.email like "%'.$searchString.'%") OR (CONCAT(a.firstname, " ", a.lastname) like "%'.$searchString.'%") ')->where('a.is_deleted',0);             
                }
                }) 
                ->make(true);
    }

    /**
     * Display a listing of the Normal users.
     * 
     * @param none
     * @return @view
     */
    public function normalUsersList()
    {  
        return view('users.normalUsers');
    }

    /**
     * Get on Normal Users List.
     * @return \Illuminate\Http\Response
     */
    public function normalUsersListDt(Accounts $Accounts, Request $request)
    {
        $searchString = $request->get('searchData');
        $get_users = $Accounts->getNormalUsersListDt();   
        return Datatables::of($get_users)
            ->filter(function ($query) use ($searchString) {
            if ($searchString) {                  
            $query->whereRaw('(a.email like "%'.$searchString.'%") OR (CONCAT(a.firstname, " ", a.lastname) like "%'.$searchString.'%") ')->whereRaw('coalesce(p.id,0) = 0')->where('a.is_deleted',0);            
            }
            }) 
            ->make(true);
    }

    /**
     * Display a listing of Allusers.
     * 
     * @param none
     * @return @view
     */
    public function allUsersList()
    {  
       return view('users.allUsers');
    }

    /**
     * Get on All Users List.
     * @return \Illuminate\Http\Response
     */
    public function allUsersListDt(Accounts $Accounts, Request $request)
    {        
        $searchString = $request->get('searchData');    
        $get_users = $Accounts->getAllUsersListDt();
        
        return Datatables::of($get_users)                 
                ->filter(function ($query) use ($searchString) {
                if ($searchString) {                     
                    $query->whereRaw('(a.email like "%'.$searchString.'%") OR (CONCAT(a.firstname, " ", a.lastname) like "%'.$searchString.'%") ')->where('a.is_deleted',0);;              
                }
                }) 
                ->make(true);
    }
    
    /**
     * Set user as premium users
     * @return  \Illuminate\Http\Response
     */
    public function setPremiumUsers(Request $request, Accounts $Accounts)
    {
        $users_arr = $request->get('arrSelected');
        $data = json_decode($users_arr);
        $currentDate = date('Y-m-d h:i:s');
        $end = date('Y-m-d h:i:s', strtotime('+1 years'));
        if(isset($data)){
            foreach($data as $email){
                $get_userid = $Accounts->getUseridByEmail($email);
                $data = array('email' => $email,'start_date' => $currentDate,'end_date' => $end, 'user_id'=> isset($get_userid->userid) ? $get_userid->userid : '');
                $PremiumUsers = PremiumUsers::where('email', '=', $email)->first();
                if ($PremiumUsers === null) {
                $insert = DB::table('premium_users')->insert($data);
                }
            }
        }
        if ($insert) {
            $message = trans('admin.set_premium_success');
            return (['success' => true, 'message' => $message, 'redirect' => true, 'url' => '/allUsersList']);
        } else {
            $message = trans('admin.db_save_error');
            return (['success' => false, 'message' => $message, 'redirect' => false, 'url' => '']);
        }
    }

    /**
     * Set user as Normal users
     * @return  \Illuminate\Http\Response
     */
    public function setNormalUsers(Request $request)
    {
        $users_arr = $request->get('arrSelected');
        $data = json_decode($users_arr);
        if(isset($data)){
            $delete = PremiumUsers::whereIn('email', $data)->delete();
        }
        if ($delete) {
            $message = trans('admin.set_normal_success');
            return (['success' => true, 'message' => $message, 'redirect' => true, 'url' => '/premiumUsersList']);
        } else {
            $message = trans('admin.db_save_error');
            return (['success' => false, 'message' => $message, 'redirect' => false, 'url' => '']);
        }
    }

    /**
     * Get normal user by userid
     * @param integer
     * @return \Illuminate\Http\Response
     */
    public function editNormalUser($id,$page, Accounts $Accounts)
    {
        
        $arrPurchasedFrom = array("SteathWebsite" => "Stealth Website", "Amazon" => "Amazon", "Other" => "Other", "DidNotPurchase" => "I Didn't Purchase Yet", "HealthClubUser" => "Health Club User", "PreferNottoSay" => "Prefer Not to say");
        if($id){
          $getUser = $Accounts->getNormaluserData($id);
        }
        $data['users'] = $getUser;
        $data['arrPurchasedFrom'] = $arrPurchasedFrom;
        $data['page'] = $page;
        return view('users.normalusersEdit',$data);
    }

    /**
     * submit Edit form for normal users
     * @return \Illuminate\Http\Response
     */
    public function editpostNormalUser(Request $request)
    {
        $confirmPass = $request->confirmPass;
        $setpremium = $request->setpremium;
        $hashPass = Hash::make($confirmPass);
        $userId = $request->userId;
        $useremail = $request->useremail;
        $userfullname = $request->userfullname;
        $currentDate = date('Y-m-d h:i:s');
        $expiry_date = $request->expiryDate_normal;
        $no_expiry = isset($request->expiry_month)?$request->expiry_month:'';
        $insert =0;
        $update =0;
        if($setpremium ==1){
            $end = isset($expiry_date) ? date('Y-m-d h:i:s', strtotime($expiry_date)): '';
            $data = array('email' => $useremail,'start_date' => $currentDate, 'end_date'=>$end,'user_id'=>$userId);
            // checking premium user is exist or not..
            $PremiumUsers = PremiumUsers::where('email', '=', $useremail)->first();
            if ($PremiumUsers === null) {
                $insert = DB::table('premium_users')->insert($data);
            
                //send mail to user
              /*  $data = [
                    'subject'  => trans('admin.welcome_subj_new') ,
                    'fullName' => $userfullname,
                    'username' => $useremail,
                    'password' => trans('admin.password'),
                    'body' => trans('admin.body_new_user_new')
                  ];
              
                  Mail::to([$useremail])->send(new Sendwelcomemail($data)); */
            }
        }
        if(isset($confirmPass)){
           $update = Accounts::where('id',$userId)->update(['password_hash' => $hashPass]);
        }
        if($no_expiry==50){
           $update = Accounts::where('id',$userId)->update(['is_non_expiring' => '1']);
        }
        if($insert >= 0 || $update >= 0){
            $message = trans('admin.db_save_success');
            return (['success' => true, 'message' => $message, 'redirect' => true, 'url' => '/allUsersList']);
        } else {
            $message = trans('admin.db_save_error');
            return (['success' => false, 'message' => $message, 'redirect' => false, 'url' => '']);
        }
    }

    /**
     * Delete Normal User
     * @return \Illuminate\Http\Response
     */
    public function deleteNormalUser(Request $request) 
    {
        $userId = $request->userId;
        // $t=time();
        // $get_account = $Accounts->getNormaluserData($userId);
        // $email_update = $get_account->useremail.$t.'_acc_del';
        // dd($email_update);
        $update = Accounts::where('id',$userId)->update(['is_deleted' => 1, 'date_deleted' => date('Y-m-d h:i:s'), 'access_token' => null]);
        if(isset($update)){
            $message = trans('admin.user_delete_success');
            return (['success' => true, 'message' => $message, 'redirect' => true, 'url' => '/normalUsersList']);
        }
    }
    /**
     * Delete Premium User
     * @return \Illuminate\Http\Response
     */
    public function deletePremiumUser(Request $request) 
    {
        $emailId = $request->emailId;
        // $t=time();
        // $email_update = $emailId.$t.'_acc_del';
        $update = Accounts::where('email',$emailId)->update(['is_deleted' => 1,'date_deleted' => date('Y-m-d h:i:s'), 'access_token' => null]);
        $delete = PremiumUsers::where('email',$emailId)->delete();
        if(isset($update)){
            $message = trans('admin.user_delete_success');
            return (['success' => true, 'message' => $message, 'redirect' => true, 'url' => '/premiumUsersList']);
        }
    }

     /**
     * Get normal user by userid
     * @param integer
     * @return \Illuminate\Http\Response
     */
    public function editPremiumUser($id,$page, PremiumUsers $Premium)
    {
        $arrPurchasedFrom = array("SteathWebsite" => "Stealth Website", "Amazon" => "Amazon", "Other" => "Other", "DidNotPurchase" => "I Didn't Purchase Yet", "HealthClubUser" => "Health Club User", "PreferNottoSay" => "Prefer Not to say");
        if($id){
          $getUser = $Premium->getPremiumuserData($id);
        }
        $data['users'] = $getUser;
        $data['arrPurchasedFrom'] = $arrPurchasedFrom;
        $data['page'] = $page;
        return view('users.premiumusersEdit',$data);
    }


    /**
     * submit edit form for premium users
     * @return \Illuminate\Http\Response
     */
    public function editpostPremiumUser(Request $request)
    {
        $confirmPass = $request->confirmPass;
        $expiryDate = $request->expiryDate;
        $setpremium = $request->setpremium;
        $hashPass = Hash::make($confirmPass);
        $userId = $request->userId;
        $useremail = $request->useremail;
        $currentDate = date('Y-m-d h:i:s');
        $update =0;
        $delete=0;
        
        if($expiryDate !=''){
            $expirydate1 = date('Y-m-d h:i:s', strtotime($expiryDate));
            $update = PremiumUsers::where('email',$useremail)->update(['end_date' => $expirydate1]);
        }
        if(isset($confirmPass)){
           $update = Accounts::where('id',$userId)->update(['password_hash' => $hashPass]);
        }
        if($setpremium ==1){
           $delete = PremiumUsers::where('email',$useremail)->delete();
           $update = Accounts::where('id',$userId)->update(['is_non_expiring' => 0]);
        }
        if($update >= 0 || $delete >= 0){
            $message = trans('admin.db_save_success');
            return (['success' => true, 'message' => $message, 'redirect' => true, 'url' => '/premiumUsersList']);
        } else
        {
            $message = trans('admin.db_save_error');
            return (['success' => false, 'message' => $message, 'redirect' => false, 'url' => '']);
        }
       
    }
    
    /**
     * Admin settings
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {         
        return view('users.settings');
    }
    
    /**
     * Change admin Password
     * @return \Illuminate\Http\Response
     */
    public function changeSettings(Request $request)
    {
        $user = Auth::user();
        $password = $request->password;
        $currentPass = $request->currentPass;
        $hashPass = Hash::make($password);
        
        if (Hash::check($currentPass, $user->password_hash) && isset($password)) {
            $update = User::where('email',$user->email)->update(['password_hash' => $hashPass]);
            if($update >=0){
                $message = trans('admin.db_save_success');
                return (['success' => true, 'message' => $message, 'redirect' => true, 'url' => '/settings']);
            } else {
                $message = trans('admin.db_save_success');
                return (['success' => false, 'message' => $message, 'redirect' => false, 'url' => '']);
            }
        }
        else {            
             return response()->json(['errors'=>['currentPass'=> trans('admin.currentPassword_not_match')]], 422);
        }
    }
    
    public function create_users()
    {

        return view('users.create_users');   

    }

    public function store_users(Request $request)
    {

        $email_check = Accounts::where('email', $request->input('email'))->where('is_deleted',0)->count();

        if($email_check == 0)
        {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email:filter|unique:accounts,date_deleted,NULL',
                'firstname'=>'required',
                // 'lastname'=>'required',
                // 'is_deleted'=>0
            ]);


            if($validator->fails())
            {

                $errors = $validator->errors()->toArray();
                $error_message = '';
                if(isset($errors['email'][0]))
                {
                    $error_message.= "Failed, ".$errors['email'][0];
                }
                else if(isset($errors['firstname'][0]))
                {
                    $error_message.= "Failed, ".$errors['firstname'][0];
                }
                else if(isset($errors['lastname'][0]))
                {
                    $error_message.= "Failed, ".$errors['lastname'][0];
                }
                else
                {
                    $error_message.= 'Failed, Validation error please fill valid email and firstname and lastname';
                }

                Session::flash('error_message', $error_message);
                return redirect('admin/create_users')->withErrors($validator)->withInput();

            }
            else{




                $email = $request->input('email');
                $userId = sha1(time()).'-'.rand(0,1000).Str::random(8);
                $user = new Accounts;
                $user->email = $email;
                $user->id = $userId;
                $no_expiry = isset($request->expiry_month)?$request->expiry_month:'';
                $user->password_hash = '$2a$10$12heg8aFqdXox5HJ1EcY3O7u0oUAGMuHkNd6gJKezst9cPNBmOTqa';
        
                if($request->input('firstname') != '')
                {
                    $user->firstname = $request->input('firstname');
                }
                
                if($request->input('lastname') != '')
                {
                    $user->lastname = $request->input('lastname');
                }

                if($request->input('mobile_no') != '')
                {
                    $user->mobile_no = trim($request->input('country_code')).'-'.$request->input('mobile_no');
                }
                
                if($request->input('age') != '')
                {
                    $user->age = $request->input('age');
                }
                
                if($request->input('gender') != '')
                {    
                    if(($request->input('gender') == 'm') || ($request->input('gender') == 'f'))
                        $user->gender = $request->input('gender');
                }

                if($no_expiry==50){

                    $user->is_non_expiring = 1;

                }
                
                $user->access_token = sha1(time()).'-'.Str::random(5);
                
                $user->is_firstlogin = 1;
                
                $user->save();


                if($request->input('premium_account'))
                {



                    $expiry_date = $request->input('expiryDate_normal');
                    $currentDate = date('Y-m-d h:i:s');


                    $end = isset($expiry_date) ? date('Y-m-d h:i:s', strtotime($expiry_date)): '';
                    $data = array('email' => $email,'start_date' => $currentDate, 'end_date'=>$end,'user_id'=>$userId);

                    $premiumusers = new PremiumUsers;
                    $premiumusers->user_id = $userId;
                    $premiumusers->email = $email;
                    $premiumusers->start_date = date('Y-m-d H:i:s');
                    $premiumusers->end_date = $end;
                    $premiumusers->save();



                    $fullNameemail = $request->input('firstname');

                    if($request->input('lastname') !== null)
                    {
                        $fullNameemail = $request->input('firstname').' '.$request->input('lastname');
                    }

                    $data = [
                            'subject'  => trans('admin.welcome_subj_new') ,
                            'fullName' => $fullNameemail,
                            'username' => $email,
                            'password' => trans('admin.password'),
                            'body' => trans('admin.body_new_user_new')
                          ];
                      
                          Mail::to([$email])->send(new Sendwelcomemail($data));


                }
                else
                {


                        $fullNameemail = $request->input('firstname');

                        if($request->input('lastname') !== null)
                        {
                            $fullNameemail = $request->input('firstname').' '.$request->input('lastname');
                        }

                          $data = [
                            'subject'  => trans('admin.welcome_subj_new') ,
                            'fullName' => $fullNameemail,
                            'username' => $email,
                            'password' => trans('admin.password'),
                            'body' => trans('admin.body_new_user_new')
                          ];
                      
                          Mail::to([$email])->send(new WelcomeMailClass($data));

                }



                Session::flash('message', "User Created Successfully.");
                return redirect('admin/allUsersList');

            }
        }
        else{
                $error_message = "This email address has already been used. Please use another.";
                Session::flash('error_message', $error_message);
                return redirect('admin/create_users')->withInput();;
        }



        exit(0);



    }
    
}
