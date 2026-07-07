<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    protected $table    = 'pages';
    protected $fillable = ['name','slug_title','slug_url','description','sort','status'];
    public function pageDetails($slug)
{
    $page = PagesModel::where('slug_url',$slug)
        ->where('status','active')
        ->firstOrFail();

    return view('public.page-details',compact('page'));
}
}
