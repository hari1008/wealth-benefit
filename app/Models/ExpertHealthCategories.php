<?php

/*
 * File: ExpertHealthCategories.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExpertHealthCategories extends Model {

    use SoftDeletes;

    protected $table = 'expert_health_categories';
    protected $primaryKey = 'expert_health_id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['expert_health_id','expert_id','category_id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
          'created_at', 'updated_at', 'deleted_at'
    ];
    public function categoriesdetail()
    {
        return $this->belongsTo('App\Models\MasterHealthCategories', 'category_id');
    }
    
}