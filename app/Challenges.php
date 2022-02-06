<?php
/**
 * @file   Subscriptions.php
 * @brief  This file is responsible for handling web services related to Subscriptions Model Queries.
 * @date   Oct, 2019
 * @author ZCO Engineer
 * @copyright (c) 2019, ZCO
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use Carbon\Carbon;

class Challenges extends Model 
{

    protected $table = 'challenges'; 
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getAllChallenges(){

        return DB::table($this->table.' as c')
                 ->select('c.id', 'c.code','c.name', DB::raw("TRIM(CONCAT(a.firstname, ' ', a.lastname)) as challenge_user") ,(DB::raw('DATE_FORMAT(c.start, "%Y/%m/%d") as hiddencreated')), (DB::raw('DATE_FORMAT(c.start, "%m/%d/%Y %H:%i:%s") as start')), (DB::raw('DATE_FORMAT(c.end, "%m/%d/%Y %H:%i:%s") as end')))                                   
                 ->leftjoin('accounts as a','a.id','=','c.owner_user_id')
                 // ->where('a.is_deleted',0)
                 // ->where('c.is_deleted',0);
                 //->orderBy('a.created','DESC');
                ->where(function($query) {
                    // $query->where('a.is_deleted', 0)
                    $query->Where('c.is_deleted',0)
                    ->Where('c.start','!=',0);
                });


    }

    public function get_Challenges($id)
    {

        // return DB::table($this->table.' as c')
        //          ->select('c.id', 'c.code','c.name', 'c.start', 'c.end', DB::raw("TRIM(CONCAT(a.firstname, ' ', a.lastname)) as challenge_user") ,(DB::raw('DATE_FORMAT(c.created, "%Y/%m/%d") as created')), 'a.policy_violation', 'a.id as account_id')                                   
        //          ->leftjoin('accounts as a','a.id','=','c.owner_user_id')
        //          ->where('c.id', $id)->where('a.is_deleted',0)->where('c.is_deleted',0)->first();



        return DB::table($this->table.' as c')
                 ->select('c.id', 'c.code','c.name','a.is_deleted as account_delete_status', DB::raw("TRIM(CONCAT(a.firstname, ' ', a.lastname)) as challenge_user") ,(DB::raw('DATE_FORMAT(c.created, "%Y/%m/%d") as created')), 'a.policy_violation', 'a.id as account_id', 
                    
                    DB::raw("(SELECT count(ac.id) FROM accounts_challenges as ac JOIN accounts as u_ac ON ac.account_id = u_ac.id WHERE challenge_code = c.code AND u_ac.is_deleted = '0') AS challenges_attendance_count"),

                     (DB::raw('DATE_FORMAT(c.start, "%m/%d/%Y %H:%i:%s") as start')), (DB::raw('DATE_FORMAT(c.end, "%m/%d/%Y %H:%i:%s") as end')))
                 ->leftjoin('accounts as a','a.id','=','c.owner_user_id')
                 ->where('c.id', $id)->where('c.is_deleted',0)->first();


    }

    public function get_challenge_attendance($code)
    {
    	return DB::table('accounts_challenges as c')->select((DB::raw('count(c.id) as challenges_attendance_count')))->leftjoin('accounts as a','a.id','=','c.account_id')
                 ->where('c.challenge_code', $code)->where('a.is_deleted',0)->count();
    }


    public function get_challenge_account_dt($code)
    {
    	return DB::table('accounts_challenges as c')->select('a.firstname', 'a.lastname', DB::raw("TRIM(CONCAT(a.firstname, ' ', a.lastname)) as challenge_user"), DB::raw('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) as age'), 'a.email', 'a.username', 'a.country', 'a.gender')->leftjoin('accounts as a','a.id','=','c.account_id')
            ->where(function($query) use ($code){
                $query->where('a.is_deleted', 0)
                    ->where('c.challenge_code', $code);
            });


        // return DB::table('accounts_challenges as c')->select('a.firstname', 'a.lastname', DB::raw("TRIM(CONCAT(a.firstname, ' ', a.lastname)) as challenge_user"), DB::raw('TIMESTAMPDIFF(YEAR, a.birthday, CURDATE()) as age'), 'a.email', 'a.username', 'a.country', 'a.gender')->leftjoin('accounts as a','a.id','=','c.account_id')
        //     ->where(function($query) use ($code){
        //         $query->where('c.challenge_code', $code);
        //     });

    }

    
}
