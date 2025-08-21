<?php

namespace App\Http\Middleware;

use App\Models\Semester;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveSemesterExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $exist = Semester::where('is_active', true)->exists();
        if ($exist)
            return $next($request);
        else {
            return response()
                ->json(
                    [
                        'success' => false,
                        'message' => 'there is no active semester'
                    ],
                    422
                );
        }
    }
}
