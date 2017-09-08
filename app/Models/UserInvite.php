<?php

/*
 * File: UserInvite.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Codes\Constant;



class UserInvite extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'user_invites';
    protected $primaryKey = 'invite_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'invitee_email_id', 'invitee_name','invited_date'
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
   protected $casts = [
       'status' => 'int',
   ];
    
    public function sender()
    {
        return $this->hasOne('App\Models\User','user_id','user_id')->select(['user_id','email','first_name','last_name','current_tier','image']);
    }

    public function receiver()
    {
        return $this->hasOne('App\Models\User','user_id','invited_user_id')->select(['user_id','email','first_name','created_at','last_name','current_tier','image']);
    }
    public static function createInvites($bulk_array){
        UserInvite::insert($bulk_array);
    }
    public static function listInvitesByEmails($email,$user_id){
        $records = UserInvite::whereIn('invitee_email_id',$email)
                            ->where('is_withdrawn', Constant::$INVITE_WITHDRAW_NO)
                            ->where('status',Constant::$INVITE_PENDING)
                            ->where('user_id',$user_id)
                            ->get();
        return $records;
    }

    public static function listRecievedInvites($userId){
        $result = UserInvite::where('invited_user_id',$userId)
                    ->where('is_withdrawn', Constant::$INVITE_WITHDRAW_NO)
                    ->where('status',Constant::$INVITE_PENDING)
                    ->with('sender.currentWeekGoal')
                    ->get();
        return $result;  
    }
   
    public static function listSentInvites($user_id){
        $result = UserInvite::where('user_invites.user_id',$user_id)
                    ->where('is_withdrawn', Constant::$INVITE_WITHDRAW_NO)
                    ->where('status',Constant::$INVITE_PENDING)
                    ->with('receiver.currentWeekGoal')
                    ->get();
        return $result;  
    }
    
    public static function listAllInvites($user_id){
        $result = UserInvite::where(function ($query) use ($user_id) {
                        $query->where('user_invites.user_id',$user_id)
                              ->orWhere('user_invites.invited_user_id',$user_id);
                    })
                    ->with('sender.currentWeekGoal')
                    ->with('receiver.currentWeekGoal')
                    ->get();
        return $result;  
    }
    
    public static function listAllAcceptedInvites($user_id){
        $result = UserInvite::select('invited_user_id','invite_id')
                                ->where('user_invites.user_id',$user_id)
                                ->where('user_invites.status',Constant::$INVITE_ACCEPTED)
                                ->with('receiver.currentWeekGoal')
                                ->with('receiver.healthScore')
                                ->get();
        return $result;  
    }
    
    public static function checkUsersInvite($invite_id,$user_id){
        
        $result = UserInvite::where(function($q) use($user_id) {
                                $q->where('user_id',$user_id)
                                  ->orWhere('invited_user_id', $user_id);
                            })
                            ->where('invite_id',$invite_id)->first();
        return $result;    
    }
    public static function withdrawInvite($invite_id){
        $invite = UserInvite::where('invite_id','=',$invite_id)->first();
        $invite->is_withdrawn = Constant::$INVITE_WITHDRAW_YES;
        $result = $invite->save();
        $invite->delete();
        if($result){
            return $invite;
        }
        else{
            return $result;
        }   
    }
    public static function updateInviteStatus($invite,$status){
        $invite->status = $status;
        $invite->save();
        if($status != Constant::$INVITE_ACCEPTED){
            $invite->delete();
        }
        return $invite;   
    }
    
    public static function getAllreadyInvitedUsersEmail($allUsersEmail){
        $allReadyInvitedUsersEmail = UserInvite::select('invitee_email_id')
                                    ->whereIn('invitee_email_id',$allUsersEmail)
                                    ->where('user_id',Auth::user()->user_id)
                                    ->where('is_withdrawn',Constant::$INVITE_WITHDRAW_NO)
                                    ->whereIn('status',[Constant::$INVITE_PENDING,Constant::$INVITE_ACCEPTED])
                                    ->pluck('invitee_email_id')
                                    ->toArray();
        return $allReadyInvitedUsersEmail;
    }
    
    public static function getInvite($user_id,$invitedUserId){
        $invite = UserInvite::where('user_id',$user_id)
                            ->where('invited_user_id',$invitedUserId)
                            ->where('is_withdrawn',Constant::$INVITE_WITHDRAW_NO)
                            ->whereIn('status',[Constant::$INVITE_PENDING,Constant::$INVITE_ACCEPTED])
                            ->first();
        return $invite;   
    }
    
    public static function insertInvites($userId,$invitedUserId){
        $invite = new UserInvite();
        $invite->user_id = $userId;
        $invite->invited_user_id = $invitedUserId;
        $invite->save();
        return $invite;  
    }
    
    public static function updateInviteFields($invite,$fields){
        foreach($fields as $key => $value){
            $invite->$key = $value;
        }
        $invite->save();
        return $invite;   
    }
    
    public static function checkIsUserBlockedOrNot($userId,$invitedUserId){
        return UserInvite::where(function($q) use ($userId,$invitedUserId) {
                                $q->where(['user_id'=>$userId,'invited_user_id'=>$invitedUserId])
                                  ->orWhere(['invited_user_id'=>$userId,'user_id'=>$invitedUserId]);
                            })
                        ->where('is_blocked', Constant::$YES)    
                        ->first(); 
    }
   
}
