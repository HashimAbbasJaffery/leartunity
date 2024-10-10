<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanAccessCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Checking if the user is Admin
        if(auth()->user()->role === "admin") {
            return $next($request);
        }

        // Checking if the user is the author of course
        $course = request()->route("course");
        if(auth()->id() === $course->author_id) {
            return $next($request);
        }

        // checking if user purchased this course
        // dd($course->author()?->is(auth()->user()) ?? null);
        if($course->purchases()->where("user_id", auth()->id())->exists()) {
            return $next($request);
        }

        // User don't have permission to access the course
        abort(403);
    }
}
