<?php

namespace App\QueryFilters;

use Closure;

class ClientName
{
    public function handle($request, Closure $next)
    {
        if (! request()->has('client_name') || strlen(request('client_name')) < 2) {
            return $next($request);
        }

        $builder = $next($request);

        return $builder->whereHas('client', function ($query) {
            return $query->where('name', 'like', '%' . request('client_name') . '%');
        });
    }
}
