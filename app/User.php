<?php

namespace App;
 
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{

    protected $table = 'admin_users';
    protected $rememberTokenName = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','email','password_hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'password_hash'
    ];

    /**
     * Get the password for the user.
     *
     * @param none
     * @return string
     */
    public function getAuthPassword() 
    {
        return $this->password_hash;
    } 
    
   
}
