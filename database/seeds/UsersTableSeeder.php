<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UsersTableSeeder extends Seeder
{
    private $defaultUsers = [
        [
            'name' => 'Super Admin',
            'email' => 'admin@billing.dev',
            'is_root' => true,
        ], [
            'name' => 'Operator',
            'email' => 'operator@billing.dev',
            'role' => 'operator',
        ], [
            'name' => 'Accountant',
            'email' => 'accountant@billing.dev',
            'role' => 'accountant',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all()->pluck('id', 'label');

        if (!User::count()) {
            foreach ($this->defaultUsers as $user) {
                $user['password'] = Hash::make('987654321');
                $user['email_verified_at'] = now();

                if (empty($user['is_root'])) {
                    $user['role_id'] = $roles[$user['role']];
                }

                (new User())->fill(Arr::except($user, 'role'))->save();
            }
        }
    }
}
