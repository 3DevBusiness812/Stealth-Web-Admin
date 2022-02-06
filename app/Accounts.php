<?php

namespace App;
 
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Accounts extends Authenticatable
{
    protected $table = 'accounts';
    protected $rememberTokenName = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstname', 'lastname', 'email', 'mobile_no', 'username'
    ];


    /**	
     * Get Normal Users Listing Details
     *
     * @param integer none
     * @return object		
     */
    public function getNormalUsersListDt()
    {
        return DB::table($this->table.' as a')
                ->select('a.id as userid','a.firstname','a.lastname','a.username','a.email as useremail','a.mobile_no',(DB::raw('DATE_FORMAT(a.created, "%m/%d/%Y") as created')),(DB::raw('DATE_FORMAT(a.created, "%Y/%m/%d") as hiddencreated')),DB::raw("TRIM(CONCAT(a.firstname, ' ', a.lastname)) as name"))
                ->leftjoin('premium_users as p','a.id','=','p.user_id')
                ->whereRaw('coalesce(p.id,0) = 0')
                ->where('a.is_deleted',0);             
    }

     /**	
     * Get All Users Listing Details
     *
     * @param integer none
     * @return object		
     */
    

     public function getAllUsersListDt()
    {
        return DB::table($this->table.' as a')
        ->select('a.id as userid','a.firstname','a.lastname','a.username','a.email as useremail','a.mobile_no','a.is_non_expiring',(DB::raw('DATE_FORMAT(a.created, "%m/%d/%Y") as created')),(DB::raw('DATE_FORMAT(a.created, "%Y/%m/%d") as hiddencreated')),(DB::raw('DATE_FORMAT(p.end_date, "%m/%d/%Y") as expiry')),DB::raw('CASE WHEN COALESCE(p.id,0) >0 THEN 1 ELSE 0 END as user_status'),DB::raw("TRIM(CONCAT(a.firstname, ' ', a.lastname)) as name"))                                   
        ->leftjoin('premium_users as p','a.id','=','p.user_id')
        ->where('a.is_deleted',0);
     }

    
     /**
      * Get Normal users details by id
      * 
      * @param integer $id
      * @return object 
      */
    public function getNormaluserData($id=null)
    {
        return DB::table($this->table.' as a')
                ->select('a.id as userid','a.firstname','a.lastname','a.username','a.email as useremail','a.mobile_no','a.gender','a.purchased_from','a.country',(DB::raw('DATE_FORMAT(a.created, "%m/%d/%Y") as created')))
                ->leftjoin('premium_users as p','a.id','=','p.user_id')
                ->where('a.id',$id)
                ->first();
    }
      
    /**	
     * Get All Users Count
     *
     * @param integer none
     * @return object		
     */
    public function getNormalUsersCount(){
        return DB::table($this->table.' as a')
                 ->select(\DB::raw("COUNT(a.email) AS count"))
                 ->leftjoin('premium_users as p','a.id','=','p.user_id')
                 ->whereRaw('coalesce(p.id,0) = 0')
                 ->where('a.is_deleted',0)
                 ->first(); 
    }

    /** Get userid by emailId
      * 
      * @param integer $emailId
      * @return object
    */
    public function getUseridByEmail($emailId)
    {
        return DB::table($this->table.' as a')
                ->select('a.id as userid')
                ->where('a.email','=',$emailId)
                ->first();
    }
}
