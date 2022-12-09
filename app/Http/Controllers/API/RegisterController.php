<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Jobs\SendEmailJob;
use App\Mail\UserVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{

    public function __invoke(RegistrationRequest $request)
    {
        $input = $request->validated();
        $input['password'] = Hash::make($request->password);
        $input['device_name'] = $request->device_name;
        $user = User::create($input);

        if ($user) {
//            for ($i = 1; $i <= 10; $i++) {
//                SendEmailJob::dispatch($user);
//            }
            SendEmailJob::dispatch($user);
//            Mail::mailer('smtp')->to($user->email)->send(new UserVerification($user));
//            event(new Registered($user));
            try {
                $token = $user->createToken('access_token')->plainTextToken;
                return response()->json([
                    "token" => $token,
                    "type" => "Bearer",
                    'username' => $user->name,
                    'message' => 'Пользователь создан, подтвердите почту',
                    'data' => $user,
                ]);
            } catch (\Exception $err) {
                $user->delete();

                return response()->json()([
                    'status' => 500,
                    'message' => $err,
                ]);
            }
        } else {
            return response()->json()([
                'status' => 500,
                'message' => 'Ошибка при создании пользователя',
            ]);
        }
    }
}
