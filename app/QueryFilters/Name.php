<?php

namespace App\QueryFilters;

use Closure;

class Name
{
    public function handle($request, Closure $next)
    {
        if (! request()->has('name') || strlen(request('name')) < 2) {
            return $next($request);
        }

        $builder = $next($request);

        return $builder->where('name', 'like', '%' . request('name') . '%');
    }
}
