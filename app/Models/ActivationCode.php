<?php

/*
 * File: ActivationCode.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Codes\Constant;

class ActivationCode extends Model
{
    protected $table = 'master_activation_codes';
    protected $primaryKey = 'code_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'deleted_at'
    ];
   
    protected $appends = [
       
    ];
    
    protected $casts = [
        'code_id' => 'integer',
        'status' => 'integer'
    ]; 
    
    public function ecosystem()
    {
        return $this->hasOne('App\Models\MasterEcosystem', 'ecosystem_id', 'ecosystem_id');
    }
    
    public function scopeCheckCodeStatus($query,$activationCode)
    {
        return $query->where('code',$activationCode)->with('ecosystem')->where('is_used',Constant::$NotUsed);
    }
    
    /**
        * 
        * Updating Used Activation Code Status
        * 
        * @param $code contains Activation code that we need to update
        * 
        * 
    */
    public static function updateUsedCode($code)
    {
        
        if($_ENV['USE_ACTIVATION_CODE'] == 'YES'){
            $activationCode = ActivationCode::where('code',$code)->first();
            $activationCode->is_used = Constant::$Used;
            $now = new \DateTime('now');
            $activationCode->deleted_at = $now->format("Y-m-d H:i:s");
            $activationCode->save();
        }
    }
    public static function deleteActivationCode($codeIds)
    {
         return ActivationCode::whereIn('code_id',$codeIds)->where('is_used',Constant::$NotUsed)->delete();

    }
    public static function checkCodeForPrivateType($activationCode)
    {
        return ActivationCode::where('code',$activationCode)->where('private_type', Constant::$YES)->first();

    }
    
    public static function getActivationCodeList(){
        $activationCode = ActivationCode::pluck('code','code_id')->toArray();
        return $activationCode;   
    }
    
}
