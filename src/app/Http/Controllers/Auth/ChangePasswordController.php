<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Domain\Global\Traits\Validation;
use Domain\MyAccount\Requests\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    public function update(ChangePasswordRequest $changePasswordRequest):JsonResponse
    {

        $auth = Auth::user();

        if (!Hash::check($changePasswordRequest->get('current_password'), $auth->password)) {
            return response()->json([
                'status' => false,
                'type' => 'error',
                'message' => 'Current Password is Invalid',
            ]);
        }

        if (strcmp($changePasswordRequest->get('current_password'), $changePasswordRequest->password) == 0) {
            return response()->json([
                'status' => false,
                'type' => 'error',
                'message' => 'New Password cannot be the same as your current password',
            ]);
        }

        $user = User::find($auth->id);
        $user->password = Hash::make($changePasswordRequest->password);
        $user->save();

        return response()->json([
            'status' => true,
            'type' => 'info',
            'title' => 'Password Updated',
            'message' => 'Your password has been successfully updated',
        ]);

    }
}
