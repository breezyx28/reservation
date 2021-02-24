<?php

namespace App\Http\Middleware;

use App\Helper\ResponseMessage;
use Closure;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = ['user'];
        if (!in_array(auth()->user()->accountType, $roles)) {
            return ResponseMessage::Error('غير مسموح', $roles);
        }
        return $next($request);
    }
}
