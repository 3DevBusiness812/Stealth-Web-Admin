<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\MountManager; 


use App\Jobs\updatePremiumSubscriptionJob;
use Config;
 
class UpdateSubscriptionCron extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatesubscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Product Details';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
//        echo date('H:m:i');
        parent::__construct();
		
		$filePath = "Test"; //Change with Config("storage.filepath");
		
    }
	
	public function handle()
    { 	 			
		$date = date("Ymd");
		$time = time();
		$s3FileName = 'BACKUP_PREMYEAR_'.$time.'__'.$date.'.csv';
		$localFileName = 'susbcriptn_dataDownloaded'.$date.'.csv';
		
		//Delete file if already there
		Storage::disk('local')->exists($localFileName) ? Storage::disk('local')->delete($localFileName) : "";
		
		$file_1 = Storage::disk('s3')->allFiles('963/out/');
		$s3path = isset($file_1[0]) ? $file_1[0] : "";
		if($s3path)
		{					
			$mountManager = new MountManager([
					's3' => \Storage::disk('s3')->getDriver(),
					'local' => \Storage::disk('local')->getDriver(),
				]);
			$mountManager->copy('s3://'.$s3path, 'local://'.$localFileName);
			
			$data = Excel::load('storage/app/'.$localFileName, function($reader) { 
				$reader->noHeading();
			})->get();
			
			 
			foreach($data as $k=>$value)
			{
				//check if the user already in premium table, then do nothing
				$mailExistprem = DB::table("premium_users")->where("email",$value[1])->count();
				
				if(!$mailExistprem)
				{
					//Check if there is a record exist in system with the mail id
					$mailExist     = DB::table("accounts")->where("email",$value[1])->count();
				
					$name = explode(" ",$value[0]);
					
					$data['exist'] = $mailExist;
					$data['fname'] = ($name[0]!='') ? $name[0] : ''; //Name from csv
					$data['lname'] = (isset($name[1])&& $name[1]!='') ? $name[1] : ''; //Name from csv
					$data['email'] = $value[1]; //Email from CSV
						
					dispatch(new updatePremiumSubscriptionJob($data));
				}
			}
			
			Storage::disk('s3')->move($s3path, '963/Backup/'.$s3FileName);
			//Delete file from local
			Storage::disk('local')->delete($localFileName);
		}
		
		
	}

        

}
