<?php

namespace Domain\Role\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (domainWisePermissions() as $key =>  $domain) {
            foreach ($domain as $permission) {
                if (count($domain) === 1 && $permission === 'all') {
                    foreach (permissions() as $pr) {
                        $this->createPermission($key, $pr);
                    }
                } else {
                    $this->createPermission($key, $permission);
                }
            }
        }
    }

    public function createPermission(
        string $domain,
        string $permission,
        ?string $guardName = 'web'
    ): void {
        Permission::create([
            'name' => slugGenerator($permission.' '.$domain),
            'domain' => $domain,
            'guard_name' => $guardName,
            'display_name' => ucfirst($permission),
        ]);
    }
}
