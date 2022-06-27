<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class CheckPoint
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       
        $user = Auth::user();
        if ($user->role_id == 1) {
            return $next($request);
        } else {
            $message= [
                'status' => false,
                'message' => 'Không có quyền truy cập',
            ];
            return response()->json($message)->setStatusCode(400);
        }
    }
}
