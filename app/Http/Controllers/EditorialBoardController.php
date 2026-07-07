<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use Illuminate\Http\Request;

class EditorialBoardController extends Controller
{
  public function index()
{
    $authors = AuthorModel::with([
        'Universities',
        'Locations',
        'Jobs'
    ])
    ->where('status', 'active')
    ->orderBy('sort', 'asc')
    ->get();

    return view('public.editorial-board', compact('authors'));
}

public function show($slug)
{
    $author = AuthorModel::with([
        'Universities',
        'Locations',
        'Jobs'
    ])
    ->where('slug_url', $slug)
    ->where('status', 'active')
    ->firstOrFail();

    return view('public.view-profile', compact('author'));
}
}
