<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class is_course_owner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $slug): Response
    {
        
        $course = Course::firstWhere("slug", $slug);
        $is_owner = $course->author()->is(auth()->user());
        if(!$is_owner) abort(403);

        return $next($request);
    }
}
