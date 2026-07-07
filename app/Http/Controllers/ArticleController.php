<?php

namespace App\Http\Controllers;

use App\Models\IssueModel;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function article()
    {
        $issues = IssueModel::with('Volume')
                    ->where('status','active')
                    ->latest()
                    ->get();

        return view('public.article.index',compact('issues'));
    }

    public function show($id)
    {
        $issue = IssueModel::with([
            'Volume'
        ])->findOrFail($id);

        $articles = \App\Models\ArticleModel::with([
            'ArticleAuthors',
            'ArticleContents',
            'Volumes',
            'Issues',
            'Universities'
        ])
        ->where('issue',$id)
        ->where('status','active')
        ->get();

        return view(
            'public.article.show',
            compact('issue','articles')
        );
    }
}