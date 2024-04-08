<?php

namespace App\Providers;

use App\Models\Scopes\ActiveScope;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        Route::bind("certificate_id", function($id) {
            return \App\Models\Certificate::where("certificate_id", $id)->where("user_id", auth()->id())->first();
        });
        Route::bind("without_scope_category", function($id) {
            return \App\Models\Category::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        });

        Route::bind("course_slug_o", function($slug) {
            return \App\Models\Course::withoutGlobalScopes()->where("slug", $slug)->first();
        });
        Route::bind("course_o", function($id) {
            return \App\Models\Course::withoutGlobalScopes()->find($id);
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware(['web'])
                ->group(base_path('routes/web.php'));
                
            Route::middleware(['web', "auth.banned"])
                ->group(base_path('routes/payment.php'));   
                
            Route::middleware(['web', "auth.banned"])
            ->group(base_path('routes/components.php'));   
            
            Route::middleware(['web', "auth.banned"])
            ->group(base_path('routes/user.php'));  

            Route::middleware(['web', "auth", "auth.banned"])
                ->prefix("review")
                ->group(base_path('routes/review.php'));  

            Route::middleware(['web', 'auth', "auth.banned"])
                ->prefix("learn")
                ->group(base_path('routes/learning.php')); 
            
            Route::middleware(["web", "auth", "is_teacher", "auth.banned"])
                ->prefix("instructor")
                ->group(base_path('routes/teaching.php'));

            Route::middleware(["web", "auth.banned", "is_admin"])
                ->prefix("admin")
                ->group(base_path("routes/admin.php"));

            Route::middleware(["web", "guest"])
                ->group(base_path("routes/ResetPassword.php"));
        });
    }
}
