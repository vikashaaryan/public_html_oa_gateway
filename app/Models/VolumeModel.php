<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolumeModel extends Model
{
    protected $table    = 'volume';
    protected $fillable = ['name','status'];
    public function Issues()
    {
        return $this->hasOne(IssueModel::class, 'volume', 'id');
    }
    public function AllIssues()
    {
        return $this->hasMany(IssueModel::class, 'volume', 'id');
    }
    
}
