<?php


/*
 * File: MasterWorks.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterWorks extends Model {

    use SoftDeletes;

    protected $table = 'master_works';
    protected $primaryKey = 'work_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
          'updated_at', 'deleted_at'
    ];
    
    public function ecosystems()
    {
        return $this->belongsToMany('App\Models\MasterEcosystem', 'ecosystem_works', 'work_id', 'ecosystem_id');
    }
    
    public function getLogoAttribute() {
        if (!empty($this->attributes['logo']) && $this->attributes['logo']!='') { 
            if(env('STORAGE_TYPE') == 'S3'){
                return $_ENV['AWS_SERVER_ROOT'] . $_ENV['AWS_BUCKET_NAME'] . $_ENV['WORK_IMAGE'] . $this->attributes['logo'];
            }
            else{
                return $_ENV['SERVER_ROOT'] . $_ENV['WORK_IMAGE'] . $this->attributes['logo'];
            }
        }
        return '';
    }
    
    public static function getWorks($type){
        $works = MasterWorks::where('type',$type)->get();
        return $works;   
    }
    
    public static function getWorksById($ids){
        $works = MasterWorks::whereIn('work_id',(array)$ids)->get();
        return $works;   
    }
    
    public static function getWorksList($type){
        $works = MasterWorks::whereIn('type',(array)$type)->pluck('work_name','work_id');
        return $works;   
    }
    
    public static function getWorksLogo($type){
        $logos = MasterWorks::where('type',$type)->where('logo','!=','')->pluck('logo');
        return $logos;   
    }
    
    
   
    public static function getWorkData($workId){
        return MasterWorks::where('work_id',$workId)->first();
    }
    
    public static function getWorksByEcoSystem($ecosystemId)
    {
         return MasterWorks::with('ecosystems')->get();
    }
    
    public static function deleteWorkData($ids)
    {
         return MasterWorks::whereIn('work_id',$ids)->delete();
    }
}