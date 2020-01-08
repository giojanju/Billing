<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Repositories\User\UserInterface;
use Auth;
use Exception;
use Hash;

use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->middleware(function ($request, $next) {
            $request['parent_id'] = Auth::user()->id;

            return $next($request);
        });

        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('users.modify', compact('roles'));
    }

    public function store(StoreUser $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $role = Role::findOrFail($validated['role_id']);
        $role->users()->create($validated);

        return redirectSuccess('users.index', 'User saved successful!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.modify', compact('roles', 'user'));
    }

    public function update(User $user, UpdateUser $request)
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirectSuccess('users.index', 'User update successful!');
    }

    public function remove(User $user)
    {
        if (data_get($user, 'is_root')) {
            return redirectFail('users.index', 'Not possible to delete root user!');
        }

        if (data_get($user, 'id') === auth()->user()->id) {
            return redirectFail('users.index', 'Not possible to delete yourself!');
        }

        try {
            $user->delete();
        } catch (Exception $e) {
            return redirectFail('users.index', $e->getMessage());
        }

        return redirectSuccess('users.index', 'User delete successful!');
    }
}
