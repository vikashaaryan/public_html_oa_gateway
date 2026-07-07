<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterLinkModel extends Model
{
    protected $table    = 'footer_link';
    protected $fillable = ['name','footer_category','footer_link','sort','status'];
    public function Category(){
        return $this->hasOne(FooterCategoryModel::class,'id','footer_category');
    }
} 
