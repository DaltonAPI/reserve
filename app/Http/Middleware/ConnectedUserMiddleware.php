<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConnectedUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $connectedUsers = $user->connectedUsers()->pluck('users.id')->toArray();
        dd($connectedUsers);

        // Check if the current user is connected with the requested user
        if ($connectedUsers && in_array($request->user_id, $connectedUsers)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
