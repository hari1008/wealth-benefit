<?php


/*
 * File: MasterIssues.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;



class MasterIssues extends Model {

   

    protected $table = 'master_issues';
    protected $primaryKey = 'issue_id';
    
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
          'created_at', 'updated_at','deleted_at'
    ];
    
    public static function getAllIssues(){
        $issues = MasterIssues::get();
        return $issues;   
    }
   
}