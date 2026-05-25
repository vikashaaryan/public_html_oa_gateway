<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    protected $table    = 'setting';
    protected $fillable = ['title','logo','mobile_number','email','copy_right'];
}
