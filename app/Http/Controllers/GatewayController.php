<?php

namespace App\Http\Controllers;

use App\Models\ArticleModel;
use App\Models\ArticleTopicModel;
use App\Models\SubjectModel;
use App\Models\TopicModel;
use App\Models\UniversityModel;

class GatewayController extends Controller
{
    public function gateway()
    {
        $subjects = SubjectModel::where('status', 'active')->get();

        $universities = UniversityModel::where('status', 'active')->get();

        $topics = TopicModel::where('status', 'active')->get();

        return view('public.gateways', compact(
            'subjects',
            'universities',
            'topics'
        ));
    }

    public function universityDetails($slug)
    {
        $university = UniversityModel::where('slug_url', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $articles = ArticleModel::with([
            'ArticleAuthors',
            'Volumes',
            'Issues',
        ])
            ->where('university', $university->id)
            ->where('status', 'active')
            ->get();

        return view(
            'public.university-details',
            compact('university', 'articles')
        );
    }

    public function topicDetails($slug)
    {
        $topic = TopicModel::where('slug_url', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $articles = ArticleTopicModel::with([
            'Article',
            'Article.ArticleAuthors',
            'Article.Volumes',
            'Article.Issues',
        ])
            ->where('topic', $topic->id)
            ->get();

        return view(
            'public.topic-details',
            compact('topic', 'articles')
        );
    }

    public function universityArticles($slug)
    {
        $university = UniversityModel::where('slug_url', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $articles = ArticleModel::with([
            'ArticleAuthors',
            'Volumes',
            'Issues',
        ])
            ->where('university', $university->id)
            ->where('status', 'active')
            ->latest()
            ->get();

        return view(
            'public.university-articles',
            compact('university', 'articles')
        );
    }
    

    public function topicArticles($slug)
    {
        $topic = TopicModel::where('slug_url', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $articleIds = ArticleTopicModel::where('topic', $topic->id)
            ->pluck('article');

        $articles = ArticleModel::with([
            'ArticleAuthors',
            'Volumes',
            'Issues',
        ])
            ->whereIn('id', $articleIds)
            ->where('status', 'active')
            ->latest()
            ->get();

        return view(
            'public.topic-articles',
            compact('topic', 'articles')
        );
    }
}
