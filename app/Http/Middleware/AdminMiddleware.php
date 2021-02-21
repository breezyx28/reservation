<?php

namespace App\Http\Middleware;

use App\Helper\ResponseMessage;
use Closure;

class AdminMiddleware
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
        if (auth()->user()->accountType != 'admin') {

            return ResponseMessage::Error('غير مصرح', 'هذا المسار مخصص فقط للمدير او الأدمن');
        }
        return $next($request);
    }
}
