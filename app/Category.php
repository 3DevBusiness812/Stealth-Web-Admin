<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;

class Category extends Model
{
    //

    protected $table = 'categories'; 
    protected $primaryKey = 'categoryid';
    public $timestamps = false;

    public function getAllCategory()
    {
    	return Category::orderBy('created', 'ASC')->get();	
    }

    public function getAllCategory_count()
    {
    	return Category::count();	
    }

}
