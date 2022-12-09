<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request  $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'Invalid url provider'
            ], 401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
//            return response()->json([
//                'status' => 200,
//                'message' => 'Email already verified',
//            ], 200);

            return redirect('http://localhost:3000/');
        } else {
            return redirect('http://localhost:3000/');
//            return response()->json([
//                'status' => 400,
//                'message' => 'Email $user->email already verified',
//            ], 400);
        }
    }
}
