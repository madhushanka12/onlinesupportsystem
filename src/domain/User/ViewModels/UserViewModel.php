<?php

namespace Domain\User\ViewModels;

use App\Models\User;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Facades\DB;
use Domain\User\Actions\ListUsersAction;
use Domain\User\Resources\UserProfileResources;
use Illuminate\Pagination\LengthAwarePaginator;

class UserViewModel extends ViewModel
{
    public function __construct(
        public int $perPage,
        public ?User $user = null
    ) {
    }

    public function users(): LengthAwarePaginator
    {
        $params = [
            'limit' => request()->has('limit') ? request()->get('limit') : 20,
            'search' => request()->has('search') ? request()->get('search') : null,
            'role' => request()->has('role') ? request()->get('role') : null,
            'type' => request()->has('type') ? request()->get('type') : null,
            'user' => request()->has('user') ? request()->get('user') : null,
        ];

        return (new ListUsersAction())->execute($params);
    }

    public function user(): array|UserProfileResources
    {
        if ($this->user) {
            return UserProfileResources::make(
                $this->user
            );
        }

        return [];
    }

    public function roles(): array
    {
        return DB::table('roles')
            ->whereNotIn('name', ['super-admin', 'admin', 'master', 'customer', 'dealer', 'driver'])
            ->get()
            ->map(function ($role) {
                return [
                    'value' => $role->id,
                    'label' => $role->display_name,
                    'slug' => $role->name,
                ];
            })->toArray();
    }
}
