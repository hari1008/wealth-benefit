<?php

/*
 * File: Setting.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helper\Utility\CommonHelper;


class Setting extends Model {

    use SoftDeletes;

    protected $table = 'settings';
    protected $primaryKey = 'setting_id';
    protected $dates = ['deleted_at'];

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
          'created_at', 'updated_at', 'deleted_at'
    ];
    
    /**
     * @function getData
     * @purpose fetch data from table on the basis of type
     * @param type $type
     * @return type
     * 
     */
    
    public static function getData($type){
        
       return Setting::where('type',$type)->first();
    }
    public static function saveData($type,$description){
        $setting = Setting::where('type',$type)->first();
        if(!is_object($setting)){
            $setting = new Setting();
        }
        $setting->type = $type;
        $setting->description = CommonHelper::scriptStripper($description);
        $setting->save();
    }
}