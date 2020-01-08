<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param bool $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = false)
    {
        if (Auth::check() && !empty($permission)) {
            $permissions = explode('.', $permission);
            logger($permissions);
            $user = $request->user();
            $count = count($permissions) - 1;

            foreach ($permissions as $key => $perm) {
                if ($user->can($perm)) {
                    break;
                } else {
                    if ($key == $count) {
                        abort(404); // Unauthorized
                    } else {
                        continue;
                    }
                }
            }
        } else {
            return redirect(route('login'));
        }

        return $next($request);
    }
}
