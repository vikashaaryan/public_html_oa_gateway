<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueModel extends Model
{
    protected $table    = 'issue';
    protected $fillable = ['name','title','volume','publish_date','description','status'];
    public function Volume(){
        return $this->belongsTo(VolumeModel::class, 'volume', 'id')->where('status', 'active');
    }
    
}
