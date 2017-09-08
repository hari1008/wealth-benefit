<?php
namespace App\Helper\Utility;

class FileRepositoryLocal{
    
    public function __construct() {
        
    }
    
    public function upload($image,$type,$name='',$thumb=0){
        $filename='';
        $thumnail_name='';
        if(is_object($image))
        {
            if ($image->isValid())
            {
                
                $extension = $image->getClientOriginalExtension();
                if($name==''){
                    
                    $filename = time().rand(111,999).'.'.$extension;
                   
                }else{
                    $filename =$this->getFilename($name);
                    
                }
                $path=$this->getPath($type);
                $image->move($path,$filename);
                
                if($thumb==1){
                    $f=  explode(".", $filename);
                    
                    $thumnail_name=$f[0]."_thumb.png";
                    exec('ffmpeg -i '.$image->getRealPath().' -ss 3 -f image2 -vframes 1 '.  $path.$thumnail_name);
                    
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
    private function getFilename($filename){
        $f=explode("/",$filename);
        $rev_arr= array_reverse($f);
        
        return $rev_arr[0];
    }
 }