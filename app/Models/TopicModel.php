<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicModel extends Model
{
    protected $table    = 'topic';
    protected $fillable = ['name','description','status'];
}
