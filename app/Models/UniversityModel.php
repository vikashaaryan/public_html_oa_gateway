<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityModel extends Model
{
    protected $table    = 'university';
    protected $fillable = ['name','description','status','location_id'];
    public function Locations(){
        return $this->hasOne(LocationModel::class,'id','location_id');
    }
}
