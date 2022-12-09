<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Already Verified'
            ];
        }

        $request->user()->sendEmailVerificationNotification();

        return ['status' => 'verification-link-sent'];
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (
            !hash_equals((string)$request->route('id'), (string)$user->getKey())
            || !hash_equals((string)$request->route('hash'), sha1($user->getEmailForVerification()))
        ) {

            return response()->json(['message' => 'Ошибка подтверждения почты!'], 500);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Почта уже подтверждена!'], 200);
        }

        if ($user->markEmailAsVerified()) {
            return redirect('http://localhost:3000/');
        }

        return response()->json(['verified' => true]);
    }
}
