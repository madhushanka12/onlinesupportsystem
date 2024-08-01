<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.passwords.email');
    }

    public function sendEmail(Request $request): JsonResponse
    {
        $this->validateEmail($request);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'type' => 'error',
                'message' => 'user not found. Please try again.',
            ]);
        }

        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);


        $user->otp = $otp;
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json([
            'status' => true,
            'type' => 'Success',
            'message' => 'OTP sent successfully.',
        ]);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $this->validate($request, [
            'otp' => 'required|digits:4',
            'email' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            if ($request->input('otp') === $user->otp) {
                return response()->json([
                    'status' => true,
                    'type' => 'success',
                    'message' => 'OTP is correct.',
                ]);
            }

            return response()->json([
                'status' => false,
                'type' => 'error',
                'message' => 'Invalid OTP. Please try again.',
            ]);
        }

        return response()->json([
            'status' => false,
            'type' => 'error',
            'message' => 'User not found.',
        ]);
    }

    public function resetPassword(Request $request): JsonResponse
    {

        $this->validate($request, [
            'password' => 'required|min:6',
            'email' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($request->input('email') === $user->email) {

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'type' => 'success',
                'message' => 'Success Change Your Password',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'type' => 'error',
                'message' => 'Password change failed. Please try again.',
            ]);
        }
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }
}
