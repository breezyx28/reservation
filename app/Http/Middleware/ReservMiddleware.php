<?php

namespace App\Http\Middleware;

use App\Helper\ResponseMessage;
use Closure;

class ReservMiddleware
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
        $roles = ['hospital', 'lab'];
        if (!in_array(auth()->user()->accountType, $roles)) {
            return ResponseMessage::Error('غير مسموح', $roles);
        }
        return $next($request);
    }
}
