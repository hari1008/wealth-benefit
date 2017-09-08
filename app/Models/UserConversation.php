<?php

/*
 * File: UserConversation.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Codes\Constant;


class UserConversation extends Authenticatable {

    use SoftDeletes;

    protected $table = 'user_conversations';
    protected $primaryKey = 'conversation_id';
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
          'updated_at', 'deleted_at'
    ];
    
    protected $casts = [
                        'sender_user_id'=>'integer',
                        'receiver_user_id'=>'integer'
                        ];
    
    public function sender()
    {
        return $this->hasOne('App\Models\User','user_id','sender_user_id')->select(array('user_id', 'first_name','last_name','image'));
    }
    
    public function reciever()
    {
        return $this->hasOne('App\Models\User','user_id','receiver_user_id')->select(array('user_id', 'first_name','last_name','image'));
    }
     
    /**
        * 
        * Insert Message
        * 
        * @param $data of message and userId
        * 
        * @return Message Object
        * 
    */
    public static function insertUserMessage($data,$userId){
        $message  = new UserConversation();
        $message->message = $data['message'];
        $message->sender_user_id = $userId;
        $message->receiver_user_id = $data['receiverId'];
        $message->timestamp = microtime(true);
        $message->save();
        return $message;
    }
    
    public static function userMessageList($data,$userId){
        $receiverId = $data['receiverId'];
        $query = UserConversation::where(function($q) use ($receiverId,$userId) {
                                $q->where(['sender_user_id'=>$userId,'receiver_user_id'=>$receiverId])
                                  ->orWhere(['receiver_user_id'=>$userId,'sender_user_id'=>$receiverId]);
                            });
        if(empty($data['type'])){                  
            $query->orderBy('timestamp','desc');
        }
        else{
            if($data['type'] == Constant::$MESSAGE_LIST_TYPE['Next']){
                $query->where('timestamp','>',$data['timestamp']);
                $query->orderBy('timestamp','asc');
            }
            else{
                $query->where('timestamp','<',$data['timestamp']);
                $query->orderBy('timestamp','desc');
            }
        }
        $query->limit(Constant::$MESSAGE_PAGINATE);
        return $query->get(); 
    }

}