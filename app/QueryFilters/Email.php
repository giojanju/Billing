<?php

namespace App\QueryFilters;

use Closure;

class Email
{
    public function handle($request, Closure $next)
    {
        if (! request()->has('email') || strlen(request('email')) < 2) {
            return $next($request);
        }

        $builder = $next($request);

        return $builder->where('email', 'like', '%' . request('email') . '%');
    }
}
