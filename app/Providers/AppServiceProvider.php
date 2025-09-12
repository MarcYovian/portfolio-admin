<?php

namespace App\Providers;

use App\Models\Achievement;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Route::bind('project', function ($slug) {
            return Project::all()->firstWhere(fn(Project $project) => Str::slug($project->title) === $slug) ?? abort(404);
        });
    }
}
