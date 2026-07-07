<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterCategoryModel extends Model
{
    protected $table    = 'footer_category';
    protected $fillable = ['name','sort','status'];
    public function Links()
    {
        return $this->hasMany(FooterLinkModel::class, 'footer_category', 'id')->where('status','active')->orderBy('sort','asc');
    }
    
}
