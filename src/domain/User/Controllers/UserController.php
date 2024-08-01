<?php

namespace Domain\User\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Domain\User\Actions\ListUsersAction;
use Inertia\Response as InertiaResponse;
use Domain\User\ViewModels\UserViewModel;
use Domain\User\Requests\UserAssignRequest;
use Domain\Global\Actions\ManageStatusAction;
use Domain\User\Actions\AssignUserLocationAction;
use Domain\User\Actions\AssignUserHierarchyAction;
use Domain\User\ViewModels\UserCreateEditViewModel;
use Domain\API\Authentication\Actions\StoreUserAction;
use Domain\API\Authentication\Requests\RegisterRequest;

class UserController extends Controller
{
    public const INDEX_ROUTE = 'users.index';

    public function index(): InertiaResponse|RedirectResponse
    {
        if (! request()->get('type') || ! request()->get('view')) {
            return redirect()->route(self::INDEX_ROUTE, [
                'type' => 'pending',
                'view' => 'table',
            ]);
        }
        $viewModel = new UserViewModel(
            20,
        );

        return Inertia::render('Users/Index', $viewModel);
    }

    public function fetch(ListUsersAction $listUsersAction): JsonResponse
    {
        $params = [
            'limit' => request()->has('limit') ? request()->get('limit') : 20,
            'search' => request()->has('search') ? request()->get('search') : null,
            'role' => request()->has('role') ? request()->get('role') : null,
            'user' => request()->has('user') ? request()->get('user') : null,
            'level' => request()->has('level') ? request()->get('level') : null,
            'type' => request()->has('type') ? request()->get('type') : null,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched users',
            'users' => $listUsersAction->execute($params),
        ]);
    }

    public function create(): InertiaResponse
    {
        $viewModel = new UserCreateEditViewModel();

        return Inertia::render('Users/CreateEdit', $viewModel);
    }

    public function show(User $user): InertiaResponse
    {
        $viewModel = new UserCreateEditViewModel($user);

        return Inertia::render('Users/CreateEdit', $viewModel);
    }

    public function store(
        RegisterRequest $registerRequest,
        StoreUserAction $storeUserAction,
    ) {
        $storeUserAction->execute(
            $registerRequest->data(),
        );

        return redirect(route(self::INDEX_ROUTE))->withFlash([
            'type' => 'success',
            'title' => 'User Saved',
            'message' => __('User :name Saved', ['name' => $registerRequest->data()->name]),
        ]);
    }

    public function update(
        User $user,
        RegisterRequest $registerRequest,
        StoreUserAction $storeUserAction,
    ) {
        $storeUserAction->execute(
            $registerRequest->data(),
            $user
        );

        return redirect(route(self::INDEX_ROUTE))->withFlash([
            'type' => 'success',
            'title' => 'User Updated',
            'message' => __('User :name Updated', ['name' => $registerRequest->data()->name]),
        ]);
    }

    public function status(
        User $user,
        Request $request,
        ManageStatusAction $manageStatusAction,
    ): RedirectResponse {
        $manageStatusAction->execute($user, $request, target: 'isActive');

        return redirect(route(self::INDEX_ROUTE, $request->query()))->withFlash([
            'type' => $request->isActive ? 'success' : 'warning',
            'title' => 'User '.($request->isActive ? 'Approved' : 'Rejected'),
            'message' => __(':name '.($request->isActive ? 'Approved' : 'Rejected'), ['name' => $user->name]),
        ]);
    }

    public function assign(
        UserAssignRequest $userAssignRequest,
        AssignUserLocationAction $assignUserLocationAction,
        AssignUserHierarchyAction $assignUserHierarchyAction,
    ) {
        $user = User::where('id', $userAssignRequest->data()->id)->first();

        $assignUserLocationAction->execute($userAssignRequest->data(), $user);

        if (! ($userAssignRequest->data()->role === 'regional-sales-manager')) {
            $assignUserHierarchyAction->execute($userAssignRequest->data());
        }

        return redirect(route(self::INDEX_ROUTE))->withFlash([
            'type' => 'success',
            'title' => 'User Assign',
            'message' => __('User Assign Success'),
        ]);
    }
}
