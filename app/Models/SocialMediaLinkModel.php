<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaLinkModel extends Model
{
    protected $table    = 'social_media_link';
    protected $fillable = ['name','sort','link','status'];
}
