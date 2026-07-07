<?php

namespace App\Http\Controllers;

use App\Models\PagesModel;
use Illuminate\Http\Request;

class PageController extends Controller
{
  public function show($slug)
{
    $page = PagesModel::where('slug_url', $slug)
        ->where('status', 'active')
        ->firstOrFail();

    return view('public.page-details', compact('page'));
}
}
