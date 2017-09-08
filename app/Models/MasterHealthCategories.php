<?php

/*
 * File: MasterHealthCategories.php
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterHealthCategories extends Model {

    use SoftDeletes;

    protected $table = 'master_health_categories';
    protected $primaryKey = 'category_id';
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
    
    
    public function experts()
    {
        return $this->belongsToMany('App\Models\User', 'expert_health_categories', 'category_id', 'expert_id');
    }
    
    public static function getUserImage($userId){
        
        $userImage=  UserImage::where('user_id',$userId)->get();
        return $userImage;
        
    }
    
    public static function deleteHealthCategoryData($ids)
    {
        MasterHealthCategories::whereIn('category_id',$ids)->get()->each(function ($category) {
            $category->experts()->detach();
        });
        return MasterHealthCategories::whereIn('category_id',$ids)->forceDelete();
    }
    
    public static function getHealthCategoryData($healthCategoryId){
        return MasterHealthCategories::where('category_id',$healthCategoryId)->first();
    }
}