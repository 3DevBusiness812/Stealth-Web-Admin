<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Challenges;
use App\Accounts;
use DataTables;
use DB;
use Session;
use Config;
use Aws\Sns\SnsClient;

class ChallengeController extends Controller
{
    // For load list challenge page
    public function list_challenges($id = 0){
        
        return view('challenges.list')->with('state', $id);

    }

    // For load list challenge datatable
    public function list_challengesDt(Request $request){


        $challenges = new Challenges();
        $searchString = $request->get('searchData');
        $get_challenges = $challenges->getAllChallenges();
        return Datatables::of($get_challenges)
                ->filter(function ($query) use ($searchString) {
                if ($searchString){                        

                    $query->where(function($query) use ($searchString) {

                        $query->whereRaw('(a.email like "%'.$searchString.'%") OR (CONCAT(a.firstname, " ", a.lastname) like "%'.$searchString.'%") OR (c.name like "%'.$searchString.'%") OR (c.code like "%'.$searchString.'%")');

                    });

                }
                }) 
                ->make(true);

    }

    // For view single challenge
    public function show($id)
    {

        $challenges = new Challenges();
        $get_challenge = $challenges->get_Challenges($id);
        if(isset($get_challenge))
        {

            $start_date = $get_challenge->start;
            $end_date = $get_challenge->end;

            $tz = Config::get('app.user_timezone');
            $tz_from = 'UTC';
            $format = 'm/d/Y H:i:s';
            $created_format = 'm/d/Y';

            return view('challenges.challenges')->with('get_challenge', $get_challenge);

        }
        else
        {
            // abort(404);
            Session::flash('message', "This challenge is not available");
            return redirect('admin/list_challenges/1');
        }

    }

    // For load edit challenge page
    public function challenges_edit($id)
    {

        $challenges = new Challenges();
        $get_challenge = $challenges->get_Challenges($id);
        if(isset($get_challenge))
        {
            return view('challenges.challenges_edit')->with('get_challenge', $get_challenge);
        }
        else{
            // abort(404);
            Session::flash('message', "This challenge is not available");
            return redirect('admin/list_challenges/1');
        }
    }

    // For show challenge attended list in datatable
    public function get_challenges_account_dt(Request $request)
    {

        $challenges = new Challenges();
        $searchString = $request->get('searchData');
        $code = $request->get('challenges_code');
        $get_challenges_account = $challenges->get_challenge_account_dt($code);
        return Datatables::of($get_challenges_account)
                ->filter(function ($query) use ($searchString) {
                if ($searchString) {

                    $query->where(function($query) use ($searchString) {                  
                    
                        $query->whereRaw('(a.email like "%'.$searchString.'%") OR (CONCAT(a.firstname, " ", a.lastname) like "%'.$searchString.'%") OR (a.firstname like "%'.$searchString.'%") OR (a.lastname like "%'.$searchString.'%") OR (a.email like "%'.$searchString.'%") OR (a.country like "%'.$searchString.'%") OR (a.gender like "%'.$searchString.'%") OR (a.age like "%'.$searchString.'%")')->where('a.is_deleted',0);

                    });             
                }
                }) 
                ->make(true);

    }

    // For delete a challenge and send warning as push notification to the challenge owner when they violate policy
    public function warning_policy_violation($id, $id1)
    {

        $account_id = $id;
        $challenge_id = $id1;

        $accounts = Accounts::where('id', '=', $account_id)->first();
        $accounts->policy_violation = ($accounts->policy_violation+1);
        $accounts->save();

        $challenges = Challenges::find($challenge_id);
        $challenges->is_deleted = 1;
        $challenges->save();

        // Push notificvation //

            if((isset($accounts->device_token)) && ($accounts->device_token != ''))
            {
                $deviceToken = $accounts->device_token;
                $os = $accounts->device_type;
                $challenges_name = $challenges->name;
                $notification_title = "Challenge ".$challenges_name." has been deleted";

                $message = "Your ".$challenges_name." challenge will be deleted, as we have found that you have violated our privacy policy.";

                $key = Config::get('app.sns_access_key_id');
                $secret = Config::get('app.sns_secret_access_key');
                $region = Config::get('app.sns_default_region');

                if($os == 'ios')
                {
                    $appArn = Config::get('app.sns_apns_arn');
                }
                else
                {
                
                    $appArn = Config::get('app.sns_gcm_arn');  
                }

                $conf_arry = [
                                'credentials' => [
                                    'key'    => $key,
                                    'secret' => $secret,
                                ],
                                'region' => $region,
                                'version' => 'latest',
                            ];

                $client = SnsClient::factory($conf_arry);

                $result = $client->createPlatformEndpoint([
                    'PlatformApplicationArn' => $appArn,
                    'Token' => $deviceToken
                ]);

                $result_array = $result->toArray();

                $service_endpoint = $result_array['EndpointArn'];

                if ($os == 'ios') {

                   $apns_payload = json_encode(array("aps" => array("alert" => $message, "sound" => "default"))); 
         
                    $messageJson = json_encode(array( "default" => $message, "APNS" => $apns_payload)); 

                }
                else
                {
                    // $gcm_payload = json_encode(array("data" => array("message" => $message, "sound" => "default")));
                    // $messageJson = json_encode(array("default" => $message, "GCM" => $gcm_payload));
                    $data = [
                        "message" => $message // You can add your custom contents here 
                    ];

                    $fcmPayload = json_encode(
                        [
                            "notification" =>
                                [
                                    "title" => $notification_title,
                                    "body" => $message,
                                    "sound" => 'default'
                                ],
                            "data" => $data // data key is used for sending content through notification.
                        ]
                    );

                    $messageJson = json_encode(["default" => $message, "GCM" => $fcmPayload]);

                }

                $result = $client->publish(array(
                    'TargetArn' => $service_endpoint,
                    'Message' => $messageJson,
                    'MessageStructure' => 'json' //raw
                ));

            }
        // Push notification //

        Session::flash('message', "This challenge has been deleted and the user warned.");
        return redirect('admin/list_challenges/1');
        
    }

    // For delete both challenge owner and challenge then send push notification when they violate policy
    public function delete_user_and_challenge($id, $id1)
    {

        $account_id = $id;
        $challenge_id = $id1;

        $accounts = Accounts::where('id', '=', $account_id)->first();
        $accounts->policy_violation = ($accounts->policy_violation+1);
        $accounts->is_deleted = 1;
        $accounts->access_token = null;
        $accounts->date_deleted = date('Y-m-d H:i:s');
        $accounts->save();

        // $deletedEmail = $accounts->email;
        $deletedUserID = $accounts->id;

        $existingPremiumUserCount = PremiumUsers::where('user_id',$deletedUserID)->count();

        if($existingPremiumUserCount > 0)
        {
            $delete = PremiumUsers::where('user_id',$deletedUserID)->delete();
        }

        $challenges = Challenges::find($challenge_id);
        $challenges->is_deleted = 1;
        $challenges->save();

        // Push notificvation //

            if((isset($accounts->device_token)) && ($accounts->device_token != ''))
            {
                $deviceToken = $accounts->device_token;
                $os = $accounts->device_type;
                $challenges_name = $challenges->name;
                $notification_title = "Both your account and Challenge ".$challenges_name." has been deleted";

                $message = "Your account and the ".$challenges_name." challenge will be deleted, as we have found that you have violated our privacy policy.";

                $key = Config::get('app.sns_access_key_id');
                $secret = Config::get('app.sns_secret_access_key');
                $region = Config::get('app.sns_default_region');

                if($os == 'ios')
                {
                    $appArn = Config::get('app.sns_apns_arn');
                }
                else
                {
                
                    $appArn = Config::get('app.sns_gcm_arn');
                }

                $conf_arry = [
                                'credentials' => [
                                    'key'    => $key,
                                    'secret' => $secret,
                                ],
                                'region' => $region,
                                'version' => 'latest',
                            ];

                $client = SnsClient::factory($conf_arry);

                $result = $client->createPlatformEndpoint([
                    'PlatformApplicationArn' => $appArn,
                    'Token' => $deviceToken
                ]);

                $result_array = $result->toArray();

                $service_endpoint = $result_array['EndpointArn'];

                if ($os == 'ios') {

                    $apns_payload = json_encode(array("aps" => array("alert" => $message, "sound" => "default"))); 
         
                    $messageJson = json_encode(array( "default" => $message, "APNS" => $apns_payload));

                }
                else
                {
                    // $gcm_payload = json_encode(array("data" => array("message" => $message, "sound" => "default")));
                    // $messageJson = json_encode(array("default" => $message, "GCM" => $gcm_payload));


                    $data = [
                        "message" => $message // You can add your custom contents here 
                    ];

                    $fcmPayload = json_encode(
                        [
                            "notification" =>
                                [
                                    "title" => $notification_title,
                                    "body" => $message,
                                    "sound" => 'default'
                                ],
                            "data" => $data // data key is used for sending content through notification.
                        ]
                    );

                    $messageJson = json_encode(["default" => $message, "GCM" => $fcmPayload]);


                }

                $result = $client->publish(array(
                    'TargetArn' => $service_endpoint,
                    'Message' => $messageJson,
                    'MessageStructure' => 'json' //raw
                )); 

            }
            
        // Push notification //


        Session::flash('message', "This challenge and the user have been removed from the application.");
        return redirect('admin/list_challenges/1');
        
    }

    // For updates challenge details
    public function update_challenges($id, Request $request)
    {
        $challenges = Challenges::find($id);
        $challenges->name = $request->input('challenge_name');
        $challenges->save();
        Session::flash('message', "Successfully updated challenge");
        return redirect('admin/list_challenges/1');
        
    }

    // For delete challenge when challenge owner already deleted or owner is not present
    public function delete_challenge($id)
    {
        $challenges = Challenges::find($id);
        $challenges->is_deleted = 1;
        $challenges->save();

        Session::flash('message', "This challenge has been deleted.");
        return redirect('admin/list_challenges/1');
    }

    public function test_push_notification()
    {

       
        // echo "Yeahhh";
        // exit(0);

        $deviceToken = "dem0DaG5Sbw:APA91bEWKy2veciBpzd8kHN6nKR1WgWrm2ckVMgVouakaJXxCSeyg_Oal2aLqM7g8wOKow0x-HFkOYBwvLvrIdTMnzjm-5TyM7HBXHYUOLBCdAsJB4J4rFxP65gW3GJk2r6X1U0wZegD";

        $os = 'android';

        $message = "Test notification";

        $key = Config::get('app.sns_access_key_id');
        $secret = Config::get('app.sns_secret_access_key');
        $region = Config::get('app.sns_default_region');

        if($os == 'ios')
        {
            $appArn = Config::get('app.sns_apns_arn');
        }
        else
        {
        
            $appArn = Config::get('app.sns_gcm_arn');
        }

        $conf_arry = [
                        'credentials' => [
                            'key'    => $key,
                            'secret' => $secret,
                        ],
                        'region' => $region,
                        'version' => 'latest',
                    ];

        $client = SnsClient::factory($conf_arry);

        $result = $client->createPlatformEndpoint([
            'PlatformApplicationArn' => $appArn,
            'Token' => $deviceToken
        ]);

        $result_array = $result->toArray();

        $service_endpoint = $result_array['EndpointArn'];

        if ($os == 'ios') {

            $apns_payload = json_encode(array("aps" => array("alert" => $message, "sound" => "default"))); 
 
            $messageJson = json_encode(array( "default" => $message, "APNS" => $apns_payload));

        }
        else
        {
            $gcm_payload = json_encode(array("data" => array("message" => $message, "sound" => "default")));
            $messageJson = json_encode(array("default" => $message, "GCM" => $gcm_payload));
        }

        $result_publish = $client->publish(array(
            'TargetArn' => $service_endpoint,
            'Message' => $messageJson,
            'MessageStructure' => 'json' //raw
        ));

        echo "<pre>";
            print_r($result_publish);
        echo "</pre>";
        exit(0);


    }

}
