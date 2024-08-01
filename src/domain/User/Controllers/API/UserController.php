<?php

namespace Domain\User\Controllers\API;

use Domain\User\Actions\RemoveProfileAvatarAction;
use Domain\User\Actions\UploadProfileAvatarAction;
use Domain\User\Requests\ProfileAvatarDeleteRequest;
use Domain\User\Requests\ProfileAvatarUploadRequest;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Models\User;
use Support\Helper\Helper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Domain\User\Actions\ListUsersAction;
use Domain\User\Actions\ListAllUsersAction;
use Domain\User\Resources\UserProfileResources;
use Domain\API\Authentication\Actions\StoreUserAction;
use Domain\API\Authentication\Requests\RegisterRequest;

class UserController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all(
        ListAllUsersAction $listAllUsersAction
    ): JsonResponse {
        $params = [
            'limit' => request()->has('limit') ? request()->get('limit') : 20,
            'search' => request()->has('search') ? request()->get('search') : null,
            'role' => request()->has('role') ? request()->get('role') : null,
            'user' => request()->has('user') ? request()->get('user') : null,
            'type' => request()->has('type') ? request()->get('type') : null,
            'date' => request()->has('date') ? request()->get('date') : null,
        ];

        if (! $params['role']) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide the role parameter',
            ]);
        }

        if (! $params['user']) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide the user parameter',
            ]);
        }

        if (! findUserById($params['user'])) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched users',
            'users' => $listAllUsersAction->execute($params),
        ]);
    }

    public function index(
        ListUsersAction $listUsersAction
    ): JsonResponse {
        $params = [
            'limit' => request()->has('limit') ? request()->get('limit') : 20,
            'search' => request()->has('search') ? request()->get('search') : null,
            'role' => request()->has('role') ? request()->get('role') : null,
            'user' => request()->has('user') ? request()->get('user') : null,
            'type' => request()->has('type') ? request()->get('type') : null,
            'date' => request()->has('date') ? request()->get('date') : null,
        ];

        if (! $params['role']) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide the role parameter',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched users',
            'users' => $listUsersAction->execute($params),
        ]);
    }

    public function profile(): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'User not logged in',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile Info',
            'user' => UserProfileResources::make(auth()->user()),
        ]);
    }

    public function update(
        RegisterRequest $registerRequest,
        StoreUserAction $storeUserAction
    ): JsonResponse {
        $user = User::find((int) request()->get('userId'));

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'Requested record not found',
            ], 422);
        }

        try {
            return $storeUserAction->execute(
                $registerRequest->data(),
                $user,
                'update'
            );
        } catch (Throwable $th) {
            return $this->throwable($th);
        }
    }

    public function upload(
        ProfileAvatarUploadRequest $profileAvatarUploadRequest,
        UploadProfileAvatarAction $uploadProfileAvatarAction
    ): JsonResponse {
        try {
            DB::beginTransaction();

            if (! Auth::check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not logged in',
                ], 401);
            }

            $user = User::where('id', $profileAvatarUploadRequest->data()->user)->first();

            if (! $user) {
                return response()->json([
                    'status'   => false,
                    'message'   => 'User not found',
                ], 422);
            }

            $uploadProfileAvatarAction->execute($profileAvatarUploadRequest->data(), $user);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profile avatar uploaded',
                'user' => UserProfileResources::make($user),
            ]);
        } catch (Throwable $th) {
            DB::rollBack();

            return $this->throwable($th);
        }
    }

    public function destroy(
        ProfileAvatarDeleteRequest $profileAvatarDeleteRequest,
        RemoveProfileAvatarAction $removeProfileAvatarAction
    ): JsonResponse {
        try {
            DB::beginTransaction();

            if (! Auth::check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not logged in',
                ], 401);
            }

            $user = User::where('id', $profileAvatarDeleteRequest->data()->user)->first();

            if (! $user) {
                return response()->json([
                    'status'   => false,
                    'message'   => 'User not found',
                ], 422);
            }

            $removeProfileAvatarAction->execute($profileAvatarDeleteRequest->data(), $user);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profile avatar removed',
                'user' => UserProfileResources::make($user),
            ]);
        } catch (Throwable $th) {
            DB::rollBack();

            return $this->throwable($th);
        }
    }
}
