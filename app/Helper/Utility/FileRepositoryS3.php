<?php
namespace App\Helper\Utility;
use App\library\aws\S3;
use Config;

class FileRepositoryS3{
    
    public function __construct() {
        $this->s3 = new S3(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
    }
    
    public function upload($image,$type,$name='',$thumb=0,$id=''){
        $filename='';$thumnail_name='';
        if(is_object($image))
        {
            
            if ($image->isValid())
            {
                
                $extension = $image->getClientOriginalExtension();
                
                $filename = rand(1,9999).time().'.'.$extension;
                
            
                $path=$this->getPath($type,$id);
                
               
                $this->s3->putObjectFile($image->getRealPath(),env('AWS_BUCKET_NAME'), $path.$filename,S3::ACL_PUBLIC_READ);
                   
               
                if($thumb==1){
                    $f=  explode(".", $filename);
                    
                    $thumnail_name=$f[0]."_thumb.png";
                    exec('ffmpeg -i '.$image->getRealPath().' -f image2 -vframes 1 '.  public_path('thumbnails/'.$thumnail_name).' > storage/logs/ffmpeglog.log');
                    
                    $this->s3->putObjectFile(public_path('thumbnails/'.$thumnail_name),env('AWS_BUCKET_NAME'), $path.$thumnail_name,S3::ACL_PUBLIC_READ); 
                    
                    unlink(public_path('thumbnails/'.$thumnail_name));
                }
                
            }
            
        }
        return array('image'=>$filename,'thumb'=>$thumnail_name);
    }
    private function getPath($type){
        switch($type){
            case 1:
                $path = $_ENV['USER_PROFILE_IMAGE_PATH'];
                break;
            case 2:
                $path = $_ENV['HEALTH_DATA_IMAGE_PATH'];
                break;
            case 3:
                $path = $_ENV['USER_QUALIFICATION_IMAGE_PATH'];
                break;
            case 4:
                $path = $_ENV['WORK_IMAGE_PATH'];
                break;
            case 5:
                $path = $_ENV['REWARD_IMAGE_PATH'];
                break;
            case 6:
                $path = $_ENV['ECOSYSTEM_IMAGE_PATH'];
                break;
            
        }
        return $path;
    }
     public function deleteImage($image_type,$file_name){
        if(!empty($file_name)){

             $uri = $image_type.'/'.$file_name;

             return $this->s3->deleteObject(env('AWS_BUCKET_NAME'),$uri);

        }



    }
 }
