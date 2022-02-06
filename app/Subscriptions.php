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

class Subscriptions extends Model 
{

    protected $table = 'subscription_details';

    /**
     * Primary Key.
     *
     * @var int
     */	
    protected $primaryKey = '';	    
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'email','user_id',  'transaction_id', 'end_date',  'is_active', 'subscription_receipt_data','device_type'
    ];          
	
    public $timestamps = true;

    /**
	 * To get expired subscription values
	 * 
	 * @param date $previousDate
	 * @param int $deviceType
	 * @return Illuminate\Database\Eloquent\Collection object		
	 */
	public function getExpiredSubscriptions($previousDate, $deviceType)
	{
         
		return DB::select("SELECT user_id,transaction_id,product_id,subscription_receipt_data,is_active FROM subscription_details
        		WHERE 
				date(end_date) <= :previousDate  
                    AND device_type = :deviceType
                    AND is_active   = :is_active",
				[
					'previousDate' => $previousDate,
                         'deviceType' => $deviceType,
                         'is_active'  => 0,
                    ]
               );
	}
     /**
     * update Subscription Details
     *
     * @param integer $userId
     * @param array $updateArray
     * @return integer		
     */
	public function updateSubscriptionDetails($userId, $updateArray)	
	{
		return DB::table($this->table)->where('user_id', $userId)
            ->update($updateArray);	
     }

     /**
     * get Subscription Details
     *
     * @param int  $userId
     * @return integer		
     */
	public function getDetails($userId)	
	{
		return DB::table($this->table)->select('user_id')->where('user_id', $userId)->first();
     }

    /**
     * To update Subscription by id
     * 
     * @param int $userId
     * @param array $subscriptionData
     * @return boolean
     */
    public function updateSubscriptionById($userId, $subscriptionData)
    { 
     
         $is_active =1;
         if (strtotime($subscriptionData['end_date']) < strtotime(Carbon::now()->format('Y-m-d H:i:s'))) {
               $is_active = 0;
         }
         $subscriptionData['is_active'] = $is_active;
          DB::table('subscription_details')
               ->where('user_id', '=', $userId)
               ->update($subscriptionData); 
          return true;
    }
	
}
