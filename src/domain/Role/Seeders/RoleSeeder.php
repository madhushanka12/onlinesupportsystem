<?php

namespace Domain\Role\Seeders;

use Support\Helper\Helper;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    use Helper;

    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        collect(roleAbilities())->each(function ($ability, $index) {
            $createdRole = Role::create([
                'name' => $index,
                'display_name' => getStringFromSlug($index),
            ]);

            $abilities = [];
            foreach ($ability['domains'] as $key =>  $domain) {
                if ($ability['type'] === 'web') {
                    foreach (domainWisePermissions()[$domain] as $permission) {
                        $abilities[] = $permission.'-'.$domain;
                    }
                }

                if ($ability['type'] === 'admin') {
                    foreach (domainWisePermissionsForAPI()[$domain] as $permission) {
                        $abilities[] = $permission.'-'.$domain;
                    }
                }
            }

            $createdRole->givePermissionTo($abilities);
        });
    }
}
