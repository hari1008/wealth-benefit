<?php

namespace App\Helpers\Utility;

/*
 * This is Utility Class of the Image
 */
use App\library\aws\S3;

class ImageHelper{
    
    public function __construct() {
        $this->s3 = new S3(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
    }
    
    public function upload($image,$type,$thumb=0,$id=''){
       
        $filename='';
        $thumnail_name='';
            if ($image->isValid())
            {
              
                $extension = $image->getClientOriginalExtension();
               
                $filename = rand(1,9999).time().'.'.$extension;
               
                $path=$this->getPath($type);
                $temp_path =  $image->getRealPath();
                
                $this->s3->putObjectFile($image->getRealPath(),env('AWS_BUCKET_NAME'), $path.$filename);
               
                if($thumb==1){
                    $f=  explode(".", $filename);
                    
                    $thumnail_name=$f[0]."_thumb.png";
                    $public_path = public_path('thumbnails/'.$thumnail_name);
                  
                    exec("ffmpeg -i $temp_path -f image2 -vframes 1   $public_path 2>&1");
                  
                    $this->s3->putObjectFile(public_path('thumbnails/'.$thumnail_name),env('AWS_BUCKET_NAME'), $path.$thumnail_name);
                    unlink(public_path('thumbnails/'.$thumnail_name));
                }
              
            } 
        return array('image'=>$filename,'thumb'=>$thumnail_name);
    }
    private function getPath($type){
        switch($type){
            case 1:
                $path   =   $_ENV['PROFILE_IMAGE'];
                break;
            case 2:
                $path   =   $_ENV['VIDEO'];
                break;  
        }
        return $path;
    }
    
 }
