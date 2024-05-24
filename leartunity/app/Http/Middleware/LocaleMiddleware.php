<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Application;

class LocaleMiddleware
{
    public function __construct(protected Application $app, protected Request $request) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(session('locale', config('app.locale')));
        $this->app->setLocale(session()->get("locale"));
        // $this->app->setLocale("iw");
        return $next($request);
    }
}
