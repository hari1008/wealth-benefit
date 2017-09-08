<?php

/*
 * File: MasterQuestions.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterQuestions extends Model {

    use SoftDeletes;

    protected $table = 'master_questions';
    protected $primaryKey = 'question_id';
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
    
    
}