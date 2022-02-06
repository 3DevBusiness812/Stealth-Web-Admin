<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;


class Videos extends Model
{
    //

    protected $table = 'videos'; 
    protected $primaryKey = 'videoid';
    public $timestamps = false;

    public function list_videos_dt($category_id = NULL)
    {

        if((isset($category_id)) && ($category_id != ''))
        {
            return DB::table($this->table.' as v')
            ->join('videocategories as vicat', 'vicat.videoid', '=', 'v.videoid')
            ->select('v.videoid', 'v.title','v.description','v.videourl',DB::raw("(SELECT GROUP_CONCAT(sc.categoryname SEPARATOR ', ') FROM videocategories as sv LEFT JOIN categories as sc ON sc.categoryid = sv.categoryid WHERE sv.videoid = v.videoid) AS categorys"))
            ->where('v.is_deleted','=',0)
            ->where('vicat.categoryid', '=', $category_id);
        }
        else
        {
            return DB::table($this->table.' as v')
            ->select('v.videoid', 'v.title','v.description','v.videourl',DB::raw("(SELECT GROUP_CONCAT(sc.categoryname SEPARATOR ', ') FROM videocategories as sv LEFT JOIN categories as sc ON sc.categoryid = sv.categoryid WHERE sv.videoid = v.videoid) AS categorys"))->where('v.is_deleted','=',0);
        }

    }

    public function list_videos_count($category_id = NULL)
    {

        if((isset($category_id)) && ($category_id != ''))
        {
            return DB::table($this->table.' as v')
            ->join('videocategories as vicat', 'vicat.videoid', '=', 'v.videoid')
            ->select('v.videoid', 'v.title','v.description','v.videourl',DB::raw("(SELECT GROUP_CONCAT(sc.categoryname SEPARATOR ', ') FROM videocategories as sv LEFT JOIN categories as sc ON sc.categoryid = sv.categoryid WHERE sv.videoid = v.videoid) AS categorys"))
            ->where('v.is_deleted','=',0)
            ->where('vicat.categoryid', '=', $category_id)->count();
        }
        else
        {
            return DB::table($this->table.' as v')
            ->select('v.videoid', 'v.title','v.description','v.videourl',DB::raw("(SELECT GROUP_CONCAT(sc.categoryname SEPARATOR ', ') FROM videocategories as sv LEFT JOIN categories as sc ON sc.categoryid = sv.categoryid WHERE sv.videoid = v.videoid) AS categorys"))->where('v.is_deleted','=',0)->count();
        }

    }

    public function category_view($video_id)
    {
    	return DB::table('videocategories as vc')
    	->select('ca.categoryname')
    	->join('categories as ca', 'ca.categoryid','=','vc.categoryid')
    	->where('vc.videoid','=',$video_id)
        ->orderBy('ca.categoryname', 'ASC')
    	->get();
    }

}
