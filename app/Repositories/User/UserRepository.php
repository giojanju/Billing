<?php

namespace App\Repositories\User;

use App\Models\User;
use Auth;

class UserRepository implements UserInterface
{
    public function all()
    {
        if (Auth::user()->can('view-own-users') && !Auth::user()->can('view-users')) {
            return Auth::user()->myUsers()->with('role')->paginate(10);
        }

        return User::with('role')->paginate(10);
    }
}
