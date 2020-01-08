<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PermissionsTableSeeder extends Seeder
{
    private $permissions = [
        [
            'label' => 'create-users',
            'display_name' => 'Create users',
            'type' => 'users',
            'roles' => []
        ], [
            'label' => 'view-users',
            'display_name' => 'View users',
            'type' => 'users',
            'roles' => ['operator']
        ], [
            'label' => 'edit-users',
            'display_name' => 'Edit users',
            'type' => 'users',
            'roles' => ['operator']
        ], [
            'label' => 'delete-users',
            'display_name' => 'Delete users',
            'type' => 'users',
            'roles' => ['operator']
        ], [
            'label' => 'create-roles',
            'display_name' => 'Create roles',
            'type' => 'roles',
            'roles' => []
        ], [
            'label' => 'view-roles',
            'display_name' => 'View roles',
            'type' => 'roles',
            'roles' => []
        ], [
            'label' => 'edit-roles',
            'display_name' => 'Edit roles',
            'type' => 'roles',
            'roles' => []
        ], [
            'label' => 'delete-roles',
            'display_name' => 'Delete roles',
            'type' => 'roles',
            'roles' => []
        ], [
            'label' => 'view-own-users',
            'display_name' => 'View own users',
            'type' => 'users',
            'roles' => ['accountant']
        ], [
            'label' => 'password-change',
            'display_name' => 'Password change',
            'type' => 'users',
            'roles' => ['accountant']
        ], [
            'label' => 'view-payments',
            'display_name' => 'View payments',
            'type' => 'payments',
            'roles' => ['operator', 'accountant']
        ], [
            'label' => 'delete-payments',
            'display_name' => 'Delete payments',
            'type' => 'payments',
            'roles' => ['accountant'],
        ], [
            'label' => 'search-by-user-id',
            'display_name' => 'Search by user id',
            'type' => 'payments',
            'roles' => ['operator', 'accountant'],
        ], [
            'label' => 'view-payments-history',
            'display_name' => 'View payment history',
            'type' => 'payments',
            'roles' => ['accountant'],
        ], [
            'label' => 'view-payments-client-name',
            'display_name' => 'View client name',
            'type' => 'payments',
            'roles' => ['accountant'],
        ], [
            'label' => 'view-payments-client-id',
            'display_name' => 'View client id',
            'type' => 'payments',
            'roles' => ['operator', 'accountant'],
        ], [
            'label' => 'view-payments-source',
            'display_name' => 'View payment source',
            'type' => 'payments',
            'roles' => ['operator', 'accountant'],
        ], [
            'label' => 'view-clients',
            'display_name' => 'View clients',
            'type' => 'clients',
            'roles' => ['accountant'],
        ], [
            'label' => 'edit-clients',
            'display_name' => 'Edit clients',
            'type' => 'clients',
            'roles' => [],
        ], [
            'label' => 'delete-clients',
            'display_name' => 'Delete clients',
            'type' => 'clients',
            'roles' => [],
        ], [
            'label' => 'search-clients',
            'display_name' => 'Search clients',
            'type' => 'clients',
            'roles' => ['accountant'],
        ], [
            'label' => 'create-clients',
            'display_name' => 'Create clients',
            'type' => 'clients',
            'roles' => ['operator'],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleWithIds = Role::all()->reduce(function ($carry, $item) {
            $carry[data_get($item, 'label')] = data_get($item, 'id');

            return $carry;
        });

        foreach ($this->permissions as $permissionItem) {
            $permission = Permission::firstOrNew(['label' => data_get($permissionItem, 'label')]);
            $permission->fill(Arr::except($permissionItem, 'roles'));
            $permission->save();

            $roleIds = array_map(function ($item) use ($roleWithIds) {
                return data_get($roleWithIds, $item);
            }, data_get($permissionItem, 'roles'));
            $roleIds = array_values(array_filter($roleIds));

            $permission->roles()->sync($roleIds);
        }
    }
}
