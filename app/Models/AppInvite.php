<?php

/*
 * File: UserInvite.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Codes\Constant;



class AppInvite extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'app_invites';
    protected $primaryKey = 'app_invite_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'invitee_email_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at','deleted_at'
    ];
   
    protected $appends = [
       
    ];
    
    /**
    * The attributes that should be casted to native types.
    *
    * @var array
    */
    protected $casts = [];
    
    
    public static function createInvites($bulk_array){
        AppInvite::insert($bulk_array);
    }
    
    public static function getAlreadyInvitedEmails($mails,$userId){
        $invite = AppInvite::where('user_id',$userId)
                            ->whereIn('invitee_email_id',$mails)
                            ->pluck('invitee_email_id')
                            ->toArray();
        return $invite;   
    }
   
}
