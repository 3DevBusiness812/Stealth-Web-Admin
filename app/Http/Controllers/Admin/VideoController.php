<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Videos;
use App\Category;
use App\VidoCategory;
use DataTables;
use DB;
use Session;
use Request as Requests;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;

class VideoController extends Controller
{
    //


    public function index($id = NULL){

        // $categories = Category::all();
        $categories = Category::orderBy('categoryname')->get();


        $videoObj = new Videos();
        $video_count = $videoObj->list_videos_count($id);


        if((isset($id)) && ($id != ''))
        {
            $category_select = $categories->find($id);;
        }
        else
        {
            $category_select = '';
        }

        return view('videos.list_videos')->with('category_select', $category_select)->with('categories', $categories)->with('video_count', $video_count);

    }

    public function list_videos_dt(Request $request)
    {

        $category = new Videos();
        $searchString = $request->get('searchData');
        $get_category = $category->list_videos_dt($searchString);
        return Datatables::of($get_category)->make(true);

    }

    public function category_view(Request $request)
    {

        $return_array = array();
        $video_id = $request->input('video_id');
        $category = new Videos();
        $get_category = $category->category_view($video_id);
        if((isset($get_category)) && ($get_category != ''))
        {
            $return_array['status'] = 1;
            $return_array['category'] = $get_category;
        }
        else
        {
            $return_array['status'] = 0;
            $return_array['message'] = 'No category found';
        }

        return json_encode($return_array);

    }

    public function create_video()
    {

        // $categories = Category::all();

        $categories = Category::orderBy('categoryname')->get();

        return view('videos.make_videos')->with('categories', $categories);

    }

    public function save_video(Requests $request)
    {

        $return_array = array();

        if($request::hasFile('image')){

            $uniqueid = uniqid();
            $time = time();
            $file = $request::file('image');
            $filename = $uniqueid.'_'.$time.'-'.$file->getClientOriginalName();
            $path = config('app.video_path');
            $file->move($path, $filename);

            $return_array['status'] = 1;
            $return_array['file_name'] = $filename;

        }

        return json_encode($return_array);

    }

    public function save_video_data_bkp(Request $request)
    {

        $video_data = $request->input('video_data');

        $video_data= json_decode($video_data, true);

        foreach ($video_data as $video_datas) {

            $video_obj = new Videos();

            $video_obj->title = $video_datas['video_title'];

            $video_obj->videourl = $video_datas['video_name'];

            $video_obj->save();

            $inserted_video_id = $video_obj->videoid;

            $video_categorys = $video_datas['video_categorys'];

            $category_data = array();

            foreach($video_categorys as $video_category)
            {

                $category_data[] = array('videoid'=>$inserted_video_id, 'categoryid'=>$video_category);
            }

            if(count($category_data) > 0)
            {
                VidoCategory::insert($category_data);
            }

        }

        $return_array = array();
        $return_array['status'] = 1;
        $return_array['message'] = "Inserted Successfully";

        return json_encode($return_array);

    }

    public function delete_video_data(Request $request)
    {
        $return_array = array();
        $filename = $request->input('video_data');
        $path = config('app.video_path');
        $data = $path.$filename;
        unlink($data);
        $return_array['status'] = 1;

        return json_encode($return_array);

    }

    public function delete_video(Request $request)
    {
        $video_id = $request->input('video_id');

        $video_obj = Videos::find($video_id);

        $video_obj->is_deleted = 1;

        $video_obj->save();

        $videoeName = $video_obj->videourl;

        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();

        $client->deleteObjects([
                'Bucket'  => config('filesystems.disks.s3.bucket'),
                'Delete' => [
                    'Objects' => [
                        [

                            'Key'    => "videos/".$videoeName

                        ]
                    ]
                ]
            ]);


        $result_array = array();

        $result_array['status'] = 1;

        $result_array['message'] = 'The video has been deleted.';

        return json_encode($result_array);

    }

    public function edit_video($id)
    {
        $video = Videos::find($id);

        $categoyies = Category::leftjoin(
            DB::raw("(SELECT c.categoryid as cat_category_id, c.categoryname as cat_category_name, cv.videoid FROM videocategories as cv LEFT JOIN categories as c ON cv.categoryid = c.categoryid WHERE cv.videoid = $id) AS videocategory"),'videocategory.cat_category_id','=','categoryid')
        ->select('categoryid', 'categoryname', 'videocategory.videoid')
        ->orderBy('categoryname', 'ASC')
        ->get();

        return view('videos.edit_videos')->with('video', $video)->with('categoyies',$categoyies);
        
    }

    public function update_video(Request $request)
    {
        parse_str($request->input('categories'), $categorys);

        $video_id = $request->input('video_id');

        $title = $request->input('title');

        $video_obj = Videos::find($video_id);

        $video_obj->title = $title;

        $video_obj->save();

        $video_cat_obj = VidoCategory::select('categoryid')->where('videoid','=',$video_id)->get();

        if((isset($video_cat_obj)) && ($video_cat_obj != ''))
        {
            $video_cat_obj = $video_cat_obj->toArray();

            $video_cat_array = array_column($video_cat_obj, 'categoryid');

            $existing_category = array_values($video_cat_array);

        }
        else
        {

            $existing_category = array();

        }

        if((isset($categorys['category'])) && ($categorys['category'] !=''))
        {

            $new_category = $categorys['category'];

        }
        else
        {
            $new_category = array();
        }

        $elements_for_delete = array_values(array_diff($existing_category,$new_category));
        
        $elements_for_add = array_values(array_diff($new_category, $existing_category));

        if(count($elements_for_delete) > 0)
        {

            $deleteobj = VidoCategory::where('videoid','=',$video_id)->whereIn('categoryid',$elements_for_delete)->delete();

        }

        if(count($elements_for_add) > 0)
        {

            foreach($elements_for_add as $cat_id)
            {

                $category_data[] = array('videoid'=>$video_id, 'categoryid'=>$cat_id);
            }

            if(count($category_data) > 0)
            {
                VidoCategory::insert($category_data);
            }

        }

        $return_array = array();

        $return_array['status'] = 1;
        $return_array['message'] = 'The details of the video have been updated successfully.';

        return json_encode($return_array);

    }

    public function get_s3_url(Request $request) 
    {             
        $response = [
            'ErrorCode' => 201,
            'Message' => trans('validation.error_occur'),
            'Data' => json_decode('{}'),
            'success'=> 0
        ];
        $input = $request->all();
         
        $generatedURL = "";
        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $imageFile = $request->input('fileInput');
        $imageFile =  str_replace(' ', '_', $imageFile);
        
        $timeStmpUniq = time().rand(90,1000);
        $imageName  =   $timeStmpUniq.$imageFile;        
        $command = $client->getCommand('PutObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key'    => "temp_videos/".$imageName,
            //'ContentType'=>'image/jpeg'
            'acl'=>'public'
        ]);
        $expiry = "+10 minutes";
        $request = $client->createPresignedRequest($command, $expiry);
        $generatedURL = (string) $request->getUri();
         
        $s3GeneratedUrl['s3_upload_url'] = $generatedURL;
        $s3GeneratedUrl['s3_file_name'] = $imageName;
        $response['ErrorCode']  = 0;
        $response['Message']    = trans('validation.generated_s3_url_success');
        $response['Data']       = $s3GeneratedUrl;
        
        $response['success']    = 1;        
        
        $this->apiResponse      = $response;
        
        unset($request);
        unset($distributors);
        unset($distributorsData);
        
        return $response;    

    }




    public function save_video_data(Request $request)
    {

        $video_data = $request->input('video_data');

        $video_data= json_decode($video_data, true);

        foreach ($video_data as $video_datas) {

            $video_obj = new Videos();

            $video_obj->title = $video_datas['video_title'];

            $video_obj->videourl = $video_datas['video_name'];

            $video_obj->save();

            $inserted_video_id = $video_obj->videoid;

            $video_categorys = $video_datas['video_categorys'];

            $category_data = array();

            foreach($video_categorys as $video_category)
            {

                $category_data[] = array('videoid'=>$inserted_video_id, 'categoryid'=>$video_category);
            }

            if(count($category_data) > 0)
            {
                VidoCategory::insert($category_data);
            }

            if(\Storage::disk('s3')->has('temp_videos/'.$video_datas['video_name']))
            { 
                
                $moved = \Storage::disk('s3')->move('temp_videos/'.$video_datas['video_name'], 'videos/'.$video_datas['video_name']);

                \Storage::disk('s3')->setVisibility('/videos/'.$video_datas['video_name'], 'public');

            }

        }

        $return_array = array();
        $return_array['status'] = 1;
        $return_array['message'] = "The video has been added successfully.";

        return json_encode($return_array);

    }

}
