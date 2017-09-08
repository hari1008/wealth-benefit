<?php

/*
 * File: PasswordReset.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PasswordReset extends Model
{
    /**
        * 
        * Insert or Update reset Token against an email
        * 
        * @param $email contains email for which we are saving reset token
        * 
        * @return reset token
        * 
    */
    public static function updateUserToken($email)
    {
        $time = time();
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789' . "$time";
        $shuffled = str_shuffle($str);
        $reset_token = $shuffled;
        $passwordReset = PasswordReset::where('email', $email)->first();
        if (is_object($passwordReset))
        {
            DB::table('password_resets')
                ->where('email',$email)
                ->update(['token' => $reset_token,'created_at'=>date('Y-m-d H:i:s')]);
        }
        else
        {
            DB::table('password_resets')->insert([
                ['email' => $email,'token' => $reset_token,'created_at' => date('Y-m-d H:i:s')]
            ]);
        }
        return $reset_token;
    }
}
