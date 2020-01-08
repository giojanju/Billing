<?php

namespace App\QueryFilters;

use Closure;

class Id
{
    public function handle($request, Closure $next)
    {
        if (! request()->has('id') || empty(request('id'))) {
            return $next($request);
        }

        $builder = $next($request);

        return $builder->where('id', request('id'));
    }
}
