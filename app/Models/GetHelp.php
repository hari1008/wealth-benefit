<?php

/*
 * File: GetHelp.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Helper\Utility\CommonHelper;

class GetHelp extends Model {

    use SoftDeletes;

    protected $table = 'get_helps';
    protected $primaryKey = 'help_id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

           'updated_at', 'deleted_at'
    ];
    public function userinfo() {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }
    protected $appends = [
       
    ];
    
    /**
        * 
        * Creating New Help Row 
        * 
        * @param $data contains description about help required
        * 
        * @return help object on success , false otherwise
        * 
    */
    public static function createHelp($data){
        $help = new GetHelp();
        $help->user_id = Auth::user()->user_id;
        $help->description = CommonHelper::scriptStripper($data['description']);
        $result = $help->save();
        if($result){
            return $help;
        }else{
            return false;
        }   
    }
   
    public static function getCountTodayHelp(){
        $count = GetHelp::where('user_id',Auth::user()->user_id)->whereRaw('Date(created_at) = CURDATE()')->count();
        return $count;
    }
}

