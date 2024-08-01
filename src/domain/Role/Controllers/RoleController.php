<?php

namespace Domain\Role\Controllers;

use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Domain\Role\Requests\RoleRequest;
use Domain\Role\Actions\ListRolesAction;
use Domain\Role\Actions\StoreRoleAction;
use Inertia\Response as InertiaResponse;
use Domain\Role\ViewModels\RoleViewModel;
use Domain\Role\Actions\DestroyRoleAction;
use Domain\Role\ViewModels\RoleCreateEditViewModel;
use Domain\Role\Actions\RefreshUserAssignedPermission;
use Domain\Role\Actions\SyncRoleWithPermissionsAction;

class RoleController extends Controller
{
    public const INDEX_ROUTE = 'settings.roles.index';

    public function index(ListRolesAction $listRolesAction): InertiaResponse
    {
        $viewModel = new RoleViewModel(
            20,
            $listRolesAction
        );

        return Inertia::render('Settings/Roles/Index', $viewModel);
    }

    public function create(): InertiaResponse
    {
        $viewModel = new RoleCreateEditViewModel();

        return Inertia::render('Settings/Roles/CreateEdit', $viewModel);
    }

    public function show(Role $role): InertiaResponse
    {
        $viewModel = new RoleCreateEditViewModel($role);

        return Inertia::render('Settings/Roles/CreateEdit', $viewModel);
    }

    public function store(
        RoleRequest $roleRequest,
        StoreRoleAction $storeRoleAction,
        SyncRoleWithPermissionsAction $syncRoleWithPermissionsAction,
    ) {
        $syncRoleWithPermissionsAction->execute(
            $roleRequest->data(),
            $storeRoleAction->execute(
                $roleRequest->data(),
            )
        );

        return redirect(route(self::INDEX_ROUTE))->withFlash([
            'type' => 'success',
            'title' => 'Role Saved',
            'message' => __('Role :name Saved', ['name' => $roleRequest->data()->name]),
        ]);
    }

    public function update(
        Role $role,
        RoleRequest $roleRequest,
        StoreRoleAction $storeRoleAction,
        SyncRoleWithPermissionsAction $syncRoleWithPermissionsAction,
        RefreshUserAssignedPermission $refreshUserAssignedPermission
    ) {
//        $refreshUserAssignedPermission->execute($roleRequest->data(), $role);

        $syncRoleWithPermissionsAction->execute(
            $roleRequest->data(),
            $storeRoleAction->execute(
                $roleRequest->data(),
                $role
            )
        );

        return redirect(route(self::INDEX_ROUTE))->withFlash([
            'type' => 'success',
            'title' => 'Role Updated',
            'message' => __('Role :name Updated', ['name' => $roleRequest->data()->name]),
        ]);
    }

    public function duplicate(
        Role $role,
    ): InertiaResponse {
        $viewModel = new RoleCreateEditViewModel($role);

        return Inertia::render('Settings/Roles/CreateEdit', $viewModel);
    }

    public function destroy(
        Role $role,
        DestroyRoleAction $destroyRoleAction
    ) {
        $destroyRoleAction->execute($role);

        return redirect(route(self::INDEX_ROUTE))->withFlash([
            'type' => 'success',
            'title' => 'Role Deleted',
            'message' => __('Role :name Deleted', ['name' => $role->name]),
        ]);
    }
}
