<?php

namespace App\Providers;

use App\Models\SettingModel;
use App\Models\FooterCategoryModel;
use App\Models\SocialMediaLinkModel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $setting = SettingModel::first();

        View::share('setting', $setting);

        View::share(
            'footerCategories',
            FooterCategoryModel::with('Links')
                ->where('status', 'active')
                ->orderBy('sort')
                ->get()
        );

        View::share(
            'socialLinks',
            SocialMediaLinkModel::where('status', 'active')
                ->orderBy('sort')
                ->get()
        );
    }
}