<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as Auth;
use App\Http\Controllers\FrontendController as Front;

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
use App\Http\Controllers\admin\SocialMediaLinkController as SocialMediaLink;
use App\Http\Controllers\admin\SettingController as Setting;
use App\Http\Controllers\admin\SubjectController as Subject;
use App\Http\Controllers\admin\SubmitArticle as SubmitArticle;
use App\Http\Controllers\admin\TopicController as Topic;
use App\Http\Controllers\admin\UniversityController as University;
use App\Http\Controllers\admin\VolumeController as Volume;
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
    return "Cache is cleared";
});
Route::get('/',[Front::class,'home'])->name('home');

Route::get('/front_archive_articles/{param1}/{param2}',[Front::class,'archive_articles'])->name('front_archive_articles');
Route::get('/front_archives',[Front::class,'archives'])->name('front_archives');
Route::get('/front_article_list',[Front::class,'article_lists'])->name('front_article_list');
Route::get('/front_articles',[Front::class,'articles'])->name('front_articles');
Route::get('/front_article_types',[Front::class,'article_types'])->name('front_article_types');
Route::get('/front_authors',[Front::class,'authors'])->name('front_authors');
Route::get('/front_banners',[Front::class,'banners'])->name('front_banners');
Route::get('/front_editors',[Front::class,'chief_editors'])->name('front_editors');
Route::get('/front_faq',[Front::class,'faq'])->name('front_faq');
Route::get('/front_footers',[Front::class,'footers'])->name('front_footers');
Route::get('/front_get_article/{param}',[Front::class,'get_article'])->name('front_get_article');
Route::get('/front_get_autor/{param}',[Front::class,'get_author'])->name('front_get_autor');
Route::get('/front_get_issue/{param}',[Front::class,'get_issue'])->name('front_get_issue');
Route::get('/front_get_subject/{param}',[Front::class,'get_subject'])->name('front_get_subject');

Route::get('/front_get_topic/{param}',[Front::class,'get_topic'])->name('front_get_topic');
Route::get('/front_get_university/{param}',[Front::class,'get_university'])->name('front_get_university');
Route::get('/front_get_volume/{param}',[Front::class,'get_volume'])->name('front_get_volume');
Route::get('/front_pages/{param}',[Front::class,'Pages'])->name('front_pages');
Route::get('/front_setting',[Front::class,'setting'])->name('front_setting');
Route::get('/front_social_media_links',[Front::class,'social_media_links'])->name('front_social_media_links');
Route::get('/front_subjects',[Front::class,'subjects'])->name('front_subjects');
Route::post('/front_submit_article',[Front::class,'submit_article'])->name('front_submit_article');
Route::get('/front_topics',[Front::class,'topics'])->name('front_topics');
Route::get('/front_universities',[Front::class,'Universites'])->name('front_universities');
Route::get('/last_articles',[Front::class,'latest'])->name('last_articles');
Route::get('/latest_subjects',[Front::class,'latest_subjects'])->name('latest_subjects');
Route::prefix('journal_admin')->group(function () {
    Route::get('/',[Login::class,'index'])->name('home_login');
    Route::post('/admin_login',[Auth::class,'login'])->name('admin_login');

    Route::resource('/article',Article::class)->except(['show', 'destroy']);
    Route::post('/article_list',[Article::class,'article_list'])->name('article_list');
    Route::get('/article_status',[Article::class,'change_status'])->name('article_status');

    Route::resource('/article_type',ArticleType::class)->except(['show', 'destroy']);
    Route::post('/article_type_list',[ArticleType::class,'article_type_list'])->name('article_type_list');
    Route::get('/article_type_status',[ArticleType::class,'change_status'])->name('article_type_status');

    Route::resource('/author',Author::class)->except(['show', 'destroy']);
    Route::post('/author_list',[Author::class,'author_list'])->name('author_list');
    Route::get('/author_status',[Author::class,'change_status'])->name('author_status');
    Route::post('/get_university',[Author::class,'get_university'])->name('get_university');


    Route::resource('/banner',Banner::class)->except(['show', 'destroy']);
    Route::post('/banner_list',[Banner::class,'banner_list'])->name('banner_list');
    Route::get('/banner_status',[Banner::class,'change_status'])->name('banner_status');

    Route::resource('/faq',FAQ::class)->except(['show', 'destroy']);
    Route::post('/faq_list',[FAQ::class,'faq_list'])->name('faq_list');
    Route::get('/faq_status',[FAQ::class,'change_status'])->name('faq_status');

    Route::resource('/footer_category',FooterCategory::class)->except(['show', 'destroy']);
    Route::post('/footer_category_list',[FooterCategory::class,'footer_category_list'])->name('footer_category_list');
    Route::get('/footer_category_status',[FooterCategory::class,'change_status'])->name('footer_category_status');

    Route::resource('/footer_link',FooterLink::class)->except(['show', 'destroy']);
    Route::post('/footer_link_list',[FooterLink::class,'footer_link_list'])->name('footer_link_list');
    Route::get('/footer_link_status',[FooterLink::class,'change_status'])->name('footer_link_status');

    Route::resource('/issue',Issue::class)->except(['show', 'destroy']);
    Route::post('/issue_list',[Issue::class,'issue_list'])->name('issue_list');
    Route::get('/issue_status',[Issue::class,'change_status'])->name('issue_status');
    Route::post('/get_issue',[Issue::class,'get_issue'])->name('get_issue');

    Route::resource('/job',Job::class)->except(['show', 'destroy']);
    Route::post('/job_list',[Job::class,'job_list'])->name('job_list');
    Route::get('/job_status',[Job::class,'change_status'])->name('job_status');

    Route::resource('/location',Location::class)->except(['show', 'destroy']);
    Route::post('/location_list',[Location::class,'location_list'])->name('location_list');
    Route::get('/location_status',[Location::class,'change_status'])->name('location_status');


    Route::resource('/page',Pages::class)->except(['show', 'destroy']);
    Route::post('/page_list',[Pages::class,'page_list'])->name('page_list');
    Route::get('/page_status',[Pages::class,'change_status'])->name('page_status');


    Route::resource('/social_media',SocialMediaLink::class)->except(['show', 'destroy']);
    Route::post('/social_media_list',[SocialMediaLink::class,'social_media_list'])->name('social_media_list');
    Route::get('/social_media_status',[SocialMediaLink::class,'change_status'])->name('social_media_status');

    Route::post('/upd_password',[Setting::class,'change_password'])->name('upd_password');
    Route::get('/change_password',[Setting::class,'change_password'])->name('change_password');

    Route::get('/setting',[Setting::class,'index'])->name('setting');
    Route::post('/update_setting',[Setting::class,'update'])->name('update_setting');

    Route::resource('/subject',Subject::class)->except(['show', 'destroy']);
    Route::post('/subject_list',[Subject::class,'subject_list'])->name('subject_list');
    Route::get('/subject_status',[Subject::class,'change_status'])->name('subject_status');

    Route::get('/submit_article',[SubmitArticle::class,'index'])->name('submit_article');
    Route::post('/submit_article_list',[SubmitArticle::class,'article_list'])->name('submit_article_list');

    Route::resource('/topic',Topic::class)->except(['show', 'destroy']);
    Route::post('/topic_list',[Topic::class,'topic_list'])->name('topic_list');
    Route::get('/topic_status',[Topic::class,'change_status'])->name('topic_status');

    Route::resource('/university',University::class)->except(['show', 'destroy']);
    Route::post('/university_list',[University::class,'university_list'])->name('university_list');
    Route::get('/university_status',[University::class,'change_status'])->name('university_status');

    Route::resource('/volume',Volume::class)->except(['show', 'destroy']);
    Route::post('/volume_list',[Volume::class,'volume_list'])->name('volume_list');
    Route::get('/volume_status',[Volume::class,'change_status'])->name('volume_status');

    Route::get('/admin_logout',[Auth::class,'logout'])->name('admin_logout');
});
