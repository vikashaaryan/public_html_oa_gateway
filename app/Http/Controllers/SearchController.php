<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleModel;
use App\Models\SubjectModel;
use App\Models\UniversityModel;
use App\Models\ArticleTypeModel;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $subjects = SubjectModel::orderBy('name')->get();
        $universities = UniversityModel::orderBy('name')->get();
        $articleTypes = ArticleTypeModel::orderBy('name')->get();

        $articles = collect();

        if (
            $request->filled('keyword') ||
            $request->filled('subject') ||
            $request->filled('university') ||
            $request->filled('article_type')
        ) {

            $articles = ArticleModel::with([
                'ArticleAuthors',
                'Volumes',
                'Issues',
                'Universities',
                'Subjects',
                'ArticleType'
            ])

            ->where('status', 'active')

            ->when($request->keyword, function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->keyword . '%');

            })

            ->when($request->subject, function ($q) use ($request) {

                $q->whereHas('Subjects', function ($subject) use ($request) {

                    $subject->where('subject.id', $request->subject);

                });

            })

            ->when($request->university, function ($q) use ($request) {

                $q->where('university', $request->university);

            })

            ->when($request->article_type, function ($q) use ($request) {

                $q->where('article_type', $request->article_type);

            })

            ->latest()
            ->get();
        }

        return view(
            'public.search',
            compact(
                'articles',
                'subjects',
                'universities',
                'articleTypes'
            )
        );
    }
}