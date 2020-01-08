<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    private $roles = [
        [
            'label' => 'operator',
            'display_name' => 'Operator',
        ], [
            'label' => 'accountant',
            'display_name' => 'Accountant',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $item) {
            $role = Role::firstOrNew(['label' => data_get($item, 'label')]);
            $role->display_name = data_get($item, 'display_name');
            $role->save();
        }
    }
}
