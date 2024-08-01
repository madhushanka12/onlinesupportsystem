<?php

namespace Database\Seeders;

use App\Models\User;
use Domain\User\Helper\UserHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $userHelper = new UserHelper();

        $roles = [
            slugGenerator('Master'),
            slugGenerator('Admin'),
        ];

        foreach ($roles as $role) {
            $user = User::factory()->create([
                'name' => ucfirst($role),
                'email' => 'onlinesupportsystem@'. $role .'.com',
                'password' => Hash::make('agent123'),
                'is_active' => true,
                'is_profile_completed' => true,
            ]);

            $user->assignRole([$role]);
            $user->givePermissionTo(Role::findByName($role)->permissions);
        }
    }
}
