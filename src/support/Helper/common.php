<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

if (! function_exists('imageCheck')) {
    function imageCheck(
        string $path,
        ?string $default = 'images/not_found.png'
    ): ?string {
        return Storage::disk('public')->exists($path) ? asset('storage/'.$path) : null;
    }
}

if (! function_exists('slugGenerator')) {
    function slugGenerator($string): string
    {
        return Str::slug($string);
    }
}

if (! function_exists('displayPrice')) {
    function displayPrice(float|int $price): string
    {
        return 'INR '.number_format($price, 2);
    }
}

if (! function_exists('getStringFromSlug')) {
    function getStringFromSlug(string $slug): string
    {
        return Str::title(str_replace('-', ' ', $slug));
    }
}

if (! function_exists('roleAbilities')) {
    function roleAbilities(): array
    {
        return [
            slugGenerator('Master') => [
                'type' => 'web',
                'domains' => domains(),
            ],
            slugGenerator('Admin') => [
                'type' => 'web',
                'domains' => domains(),
            ],
        ];
    }
}

if (! function_exists('domainWisePermissions')) {
    function domainWisePermissions(): array
    {
        return [
            'dashboard' => permissions(['all', 'fetch', 'create', 'duplicate', 'store', 'show', 'status', 'move', 'update', 'destroy']),
            'tests' => permissions(['all', 'fetch', 'duplicate', 'move']),
            'roles' => permissions(['all', 'fetch', 'duplicate', 'move']),
            'tickets' => permissions(['all', 'fetch', 'duplicate', 'move']),
        ];
    }
}

if (! function_exists('domainWisePermissionsForAPI')) {
    function domainWisePermissionsForAPI(): array
    {
        return [
            'dashboard' => permissions(['all', 'fetch', 'create', 'duplicate', 'store', 'show', 'status', 'move', 'update', 'destroy']),
        ];
    }
}

if (! function_exists('permissions')) {
    function permissions(?array $except = []): array
    {
        $permissions = [
            'all',
            'index',
            'create',
            'store',
            'show',
            'fetch',
            'view',
            'status',
            'move',
            'update',
            'destroy',
        ];

        if (! empty($except)) {
            return array_values(
                array_flip(
                    array_diff_key(array_flip($permissions), array_flip($except))
                )
            );
        }

        return $permissions;
    }
}

if (! function_exists('domains')) {
    function domains(): array
    {
        return [
            'dashboard',
            'tickets',
        ];
    }
}

if (! function_exists('menus')) {
    function menus(): array
    {
        return [
            [
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'params' => [],
                'icon' => 'HomeIcon',
                'component' => 'Dashboard',
                'access' => checkIfRouteRestricted('dashboard'),
                'children' => null,
                'hasChildren' => false,
            ],
            [
                'name' => 'Tickets',
                'route' => 'tickets.index',
                'params' => [],
                'icon' => 'ChartBarIcon',
                'component' => 'Tickets/Index',
                'access' => checkIfRouteRestricted('tickets'),
                'children' => null,
                'hasChildren' => false,
            ],

        ];
    }
}

if (! function_exists('checkIfRouteRestricted')) {
    function checkIfRouteRestricted($domain): bool
    {
        return in_array($domain, array_values(
            getUserAssignedUniqueDomains()
        ), true);
    }
}

if (! function_exists('getUserAssignedUniqueDomains')) {
    function getUserAssignedUniqueDomains(?string $column = 'domain', $user = null)
    {
        $user = $user ?: auth()->user();

        return $user ? $user->permissions->pluck($column)->unique()->toArray() : [];
    }
}

if (! function_exists('findUserById')) {
    function findUserById(int $id)
    {
        return User::where('id', $id)->first();
    }
}

if (! function_exists('updateFolderPermissions')) {
    function updateFolderPermissions($path): void
    {
        $directories = File::directories($path);

        foreach ($directories as $directory) {
            File::chmod($directory, 0777);
            updateFolderPermissions($directory);
        }
    }
}

if (! function_exists('domainStates')) {
    function domainStates(?string $domain = 'register'): bool|int|string
    {
        $domains = [
            'register' => 'register',
            'created' => 'created',
            'pending-approval' => 'pending-approval',
            're-scheduled' => 're-scheduled',
            'approved' => 'approved',
            'completed' => 'completed',
            'delivered' => 'delivered',
            'rejected' => 'rejected',
            'subscribed' => 'subscribed',
            'updated' => 'updated',
            'canceled' => 'canceled',
            'payment' => 'payment',
            'assigned' => 'assigned',
            'allocated' => 'allocated',
            'called' => 'called',
        ];

        return array_search($domain, $domains, true);
    }
}

if (! function_exists('notificationStates')) {
    function notificationStates(?string $state = 'push'): bool|int|string
    {
        $states = [
            'general' => 'general',
            'offer' => 'offer',
            'push' => 'push',
            'call' => 'call',
        ];

        return array_search($state, $states, true);
    }
}

if (!function_exists('folderTypes')) {
    function folderTypes(): Collection
    {
        return collect(['thumbnail', 'large', 'medium']);
    }
}
