<?php

namespace App;
 
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class PremiumUsers extends Authenticatable
{

  protected $table = 'premium_users';
  protected $rememberTokenName = false;
  public $timestamps = false;
  
  /**
   * Primary Key.
   *
   * @var int
  */	

  protected $primaryKey = 'email';  

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id',  'email', 'start_date', 'end_date'
  ];

  /**	
   * Get Premium Users Listing Details
   *
   * @param integer none
   * @return object		
   */
  public function getPremiumUsersListDt()
  {
    return DB::table($this->table.' as p')
    ->select('a.id as userid','a.firstname','a.lastname','a.username','a.email as useremail','a.mobile_no','a.is_non_expiring',(DB::raw('DATE_FORMAT(p.end_date, "%m/%d/%Y") as expiry')),(DB::raw('DATE_FORMAT(a.created, "%m/%d/%Y") as created')),(DB::raw('DATE_FORMAT(a.created, "%Y/%m/%d") as hiddencreated')),(DB::raw('DATE_FORMAT(p.end_date, "%Y/%m/%d") as hiddenexpiry')),DB::raw("TRIM(CONCAT(a.firstname, ' ', a.lastname)) as name"))
    ->join('accounts as a','p.user_id','=','a.id')
    ->where('a.is_deleted',0);

  }


  /**
    * Get premium users details 
    * 
    * @param integer $id
    * @return object
  */
  public function getPremiumuserData($id=null)
  {
      return DB::table($this->table.' as p')
      ->select('a.id as userid','a.firstname','a.lastname','a.username','a.email as useremail','a.mobile_no','a.gender','a.purchased_from','a.country','a.is_non_expiring',(DB::raw('DATE_FORMAT(p.end_date, "%m/%d/%Y") as expiry')),(DB::raw('DATE_FORMAT(a.created, "%m/%d/%Y") as created')))
      ->join('accounts as a','p.user_id','=','a.id')
      ->where('a.id',$id)
      ->first();
  }

  /**	
   * Get Premium Users Count
   *
   * @param integer none
   * @return object		
  */ 
  public function getPremiumUsersCount()
  {
      return DB::table($this->table.' as p')
                ->select(\DB::raw("COUNT(p.email) AS count"))
                ->join('accounts as a','p.user_id','=','a.id')
                ->where('a.is_deleted',0)
                ->first();
  }

}
