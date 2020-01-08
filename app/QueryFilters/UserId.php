<?php

namespace App\QueryFilters;

use Closure;

class UserId
{
    public function handle($request, Closure $next)
    {
        if (! request()->has('user_id') || empty(request('user_id'))) {
            return $next($request);
        }

        $builder = $next($request);

        return $builder->where('user_id', request('user_id'));
    }
}
