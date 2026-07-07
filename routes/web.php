<?php

use App\Http\Controllers\admin\ArticleController as Article;
use App\Http\Controllers\admin\ArticleTypeController as ArticleType;
use App\Http\Controllers\admin\AuthorController as Author;
use App\Http\Controllers\admin\BannerController as Banner;
use App\Http\Controllers\admin\FaqController as FAQ;
use App\Http\Controllers\admin\FooterCategoryController as FooterCategory;
use App\Http\Controllers\admin\FooterLinkController as FooterLink;
use App\Http\Controllers\admin\IssueController as Issue;
use App\Http\Controllers\admin\JobController as Job;
use App\Http\Controllers\admin\LocationController as Location;
use App\Http\Controllers\admin\LoginController as Login;
use App\Http\Controllers\admin\PagesController as Pages;
use App\Http\Controllers\admin\SettingController as Setting;
use App\Http\Controllers\admin\SocialMediaLinkController as SocialMediaLink;
use App\Http\Controllers\admin\SubjectController as Subject;
use App\Http\Controllers\admin\SubmitArticle;
use App\Http\Controllers\admin\TopicController as Topic;
use App\Http\Controllers\admin\UniversityController as University;
use App\Http\Controllers\admin\VolumeController as Volume;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController as Auth;
use App\Http\Controllers\EditorialBoardController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicSubjectController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubmitArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/env-check', function () {
    return [
        'APP_ENV' => env('APP_ENV'),
        'APP_DEBUG' => env('APP_DEBUG'),
        'APP_URL' => env('APP_URL'),
    ];
});
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize');

    return 'Cache is cleared';
});

Route::prefix('journal_admin')->group(function () {
    Route::get('/', [Login::class, 'index'])->name('home_login');
    Route::post('/admin_login', [Auth::class, 'login'])->name('admin_login');

    Route::resource('/article', Article::class)->except(['show', 'destroy']);
    Route::post('/article_list', [Article::class, 'article_list'])->name('article_list');
    Route::get('/article_status', [Article::class, 'change_status'])->name('article_status');

    Route::resource('/article_type', ArticleType::class)->except(['show', 'destroy']);
    Route::post('/article_type_list', [ArticleType::class, 'article_type_list'])->name('article_type_list');
    Route::get('/article_type_status', [ArticleType::class, 'change_status'])->name('article_type_status');

    Route::resource('/author', Author::class)->except(['show', 'destroy']);
    Route::post('/author_list', [Author::class, 'author_list'])->name('author_list');
    Route::get('/author_status', [Author::class, 'change_status'])->name('author_status');
    Route::post('/get_university', [Author::class, 'get_university'])->name('get_university');

    Route::resource('/banner', Banner::class)->except(['show', 'destroy']);
    Route::post('/banner_list', [Banner::class, 'banner_list'])->name('banner_list');
    Route::get('/banner_status', [Banner::class, 'change_status'])->name('banner_status');

    Route::resource('/faq', FAQ::class)->except(['show', 'destroy']);
    Route::post('/faq_list', [FAQ::class, 'faq_list'])->name('faq_list');
    Route::get('/faq_status', [FAQ::class, 'change_status'])->name('faq_status');

    Route::resource('/footer_category', FooterCategory::class)->except(['show', 'destroy']);
    Route::post('/footer_category_list', [FooterCategory::class, 'footer_category_list'])->name('footer_category_list');
    Route::get('/footer_category_status', [FooterCategory::class, 'change_status'])->name('footer_category_status');

    Route::resource('/footer_link', FooterLink::class)->except(['show', 'destroy']);
    Route::post('/footer_link_list', [FooterLink::class, 'footer_link_list'])->name('footer_link_list');
    Route::get('/footer_link_status', [FooterLink::class, 'change_status'])->name('footer_link_status');

    Route::resource('/issue', Issue::class)->except(['show', 'destroy']);
    Route::post('/issue_list', [Issue::class, 'issue_list'])->name('issue_list');
    Route::get('/issue_status', [Issue::class, 'change_status'])->name('issue_status');
    Route::post('/get_issue', [Issue::class, 'get_issue'])->name('get_issue');

    Route::resource('/job', Job::class)->except(['show', 'destroy']);
    Route::post('/job_list', [Job::class, 'job_list'])->name('job_list');
    Route::get('/job_status', [Job::class, 'change_status'])->name('job_status');

    Route::resource('/location', Location::class)->except(['show', 'destroy']);
    Route::post('/location_list', [Location::class, 'location_list'])->name('location_list');
    Route::get('/location_status', [Location::class, 'change_status'])->name('location_status');

    Route::resource('/page', Pages::class)->except(['show', 'destroy']);
    Route::post('/page_list', [Pages::class, 'page_list'])->name('page_list');
    Route::get('/page_status', [Pages::class, 'change_status'])->name('page_status');

    Route::resource('/social_media', SocialMediaLink::class)->except(['show', 'destroy']);
    Route::post('/social_media_list', [SocialMediaLink::class, 'social_media_list'])->name('social_media_list');
    Route::get('/social_media_status', [SocialMediaLink::class, 'change_status'])->name('social_media_status');

    Route::post('/upd_password', [Setting::class, 'change_password'])->name('upd_password');
    Route::get('/change_password', [Setting::class, 'change_password'])->name('change_password');

    Route::get('/setting', [Setting::class, 'index'])->name('setting');
    Route::post('/update_setting', [Setting::class, 'update'])->name('update_setting');

    Route::resource('/subject', Subject::class)->except(['show', 'destroy']);
    Route::post('/subject_list', [Subject::class, 'subject_list'])->name('subject_list');
    Route::get('/subject_status', [Subject::class, 'change_status'])->name('subject_status');

    Route::get('/submit_article', [SubmitArticle::class, 'index'])->name('submit_article');
    Route::post('/submit_article_list', [SubmitArticle::class, 'article_list'])->name('submit_article_list');

    Route::resource('/topic', Topic::class)->except(['show', 'destroy']);
    Route::post('/topic_list', [Topic::class, 'topic_list'])->name('topic_list');
    Route::get('/topic_status', [Topic::class, 'change_status'])->name('topic_status');

    Route::resource('/university', University::class)->except(['show', 'destroy']);
    Route::post('/university_list', [University::class, 'university_list'])->name('university_list');
    Route::get('/university_status', [University::class, 'change_status'])->name('university_status');

    Route::resource('/volume', Volume::class)->except(['show', 'destroy']);
    Route::post('/volume_list', [Volume::class, 'volume_list'])->name('volume_list');
    Route::get('/volume_status', [Volume::class, 'change_status'])->name('volume_status');

    Route::get('/admin_logout', [Auth::class, 'logout'])->name('admin_logout');
});

Route::get('/', [PublicSubjectController::class, 'subject'])->name('home');
Route::get('/subject/{slug}', [PublicSubjectController::class, 'subjectdetails'])
    ->name('subjectdetails');
Route::get('/article', [
    ArticleController::class,
    'article',
])->name('article');
Route::get('/subject/{slug}/articles', [PublicSubjectController::class, 'subjectArticles'])
    ->name('subject.articles');

Route::get('/article/show/{id}', [
    ArticleController::class,
    'show',
])->name('show.article');
Route::get('gateway', [GatewayController::class, 'gateway'])->name('gateway');
Route::get('/university/{slug}', [GatewayController::class, 'universityDetails'])
    ->name('university.details');

Route::get('/topic/{slug}', [GatewayController::class, 'topicDetails'])
    ->name('topic.details');

Route::get('/university/{slug}/articles', [GatewayController::class, 'universityArticles'])
    ->name('university.articles');

Route::get(
    '/submit-article',
    [SubmitArticleController::class, 'Submitarticle']
)->name('submit.article');

Route::post(
    '/submit-article/store',
    [SubmitArticleController::class, 'store']
)->name('submit.article.store');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/editorial-board', [EditorialBoardController::class, 'index'])
    ->name('editorial.board');

Route::get('/editorial-board/{slug}', [EditorialBoardController::class, 'show'])
    ->name('editorial.profile');

Route::get('/page/{slug}', [PageController::class, 'show'])
    ->name('page.show');
Route::get('/topic/{slug}/articles', [GatewayController::class, 'topicArticles'])
    ->name('topic.articles');