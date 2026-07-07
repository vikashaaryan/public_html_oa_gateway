<?php

namespace App\Http\Controllers;

use App\Models\ArticleSubjectModel;
use App\Models\SubjectModel;

class PublicSubjectController extends Controller
{
    public function subject()
    {
        $subjects = SubjectModel::where('status', 'active')->get();

        return view('public.home', compact('subjects'));
    }

    public function subjectdetails($slug)
    {
        $subject = SubjectModel::where('slug_url', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('public.subject-details', compact('subject'));
    }

    public function subjectArticles($slug)
    {
        $subject = SubjectModel::where('slug_url', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $articles = ArticleSubjectModel::with([
            'Article.ArticleAuthors',
            'Article.Issues',
            'Article.Volumes',
        ])
            ->where('subject', $subject->id)
            ->whereHas('Article', function ($query) {
                $query->where('status', 'active');
            })
            ->get();

        return view('public.subject-articles', compact(
            'subject',
            'articles'
        ));
    }
}
