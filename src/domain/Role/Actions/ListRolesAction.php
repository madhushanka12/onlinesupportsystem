<?php

namespace Domain\Role\Actions;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ListRolesAction
{
    public function execute(
        ?array $params
    ): LengthAwarePaginator {
        $search = $params['search'] ?? null;

        return Role::query()
            ->with('permissions')
            ->when($search, function (Builder $builder) use ($search) {
                return $builder
                    ->where('name', 'LIKE', "%$search%")
                    ->orWhere('display_name', 'LIKE', "%$search%");
            })
            ->latest('created_at')
            ->paginate($params['limit'] ?? 20)
            ->withQueryString()
            ->through(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'displayName' => $role->display_name,
                    'guardName' => $role->guard_name,
                    'disableAction' => in_array(auth()->user()->email, $role->users()->get()->pluck('email')->toArray(), true),
                    'permissions' => collect($role->permissions)->map(function ($permission) {
                        return [
                            'name' => $permission['name'],
                            'displayName' => $permission['display_name'],
                            'domain' => $permission['domain'],
                        ];
                    }),
                ];
            });
    }
}
