<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreRole;

use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('type');

        return view('roles.modify', compact('permissions'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::with('roles')->get()->groupBy('type');

        $permissionCounts = $role->permissions()->get()->groupBy('type')->map(function ($item) {
            return $item->count();
        });

        return view('roles.modify', compact('permissions', 'role', 'permissionCounts'));
    }

    public function store(StoreRole $request)
    {
        return $this->createOrUpdate($request);
    }

    public function update(Role $role, StoreRole $request)
    {
        return $this->createOrUpdate($request, $role);
    }

    public function remove(Role $role)
    {
        try {
            $role->delete();
        } catch (\Exception $e) {
            return redirectFail('roles.index', 'Role deleted successful!');
        }

        return redirectSuccess('roles.index', 'Role deleted successful!');
    }

    /**
     * @param FormRequest $request
     * @param Model|null $model
     * @return mixed
     */
    private function createOrUpdate(FormRequest $request, Model $model = null)
    {
        $validated = $request->validated();
        $message = 'Role update successful!';

        if (!$model) {
            $message = 'New role created successful!';
            $model = new Role;
        }

        $model->fill(Arr::except($validated, 'permissions'));
        $model->save();

        $model->permissions()->sync(data_get($validated, 'permissions', []));

        return redirectSuccess('roles.index', $message);
    }
}
