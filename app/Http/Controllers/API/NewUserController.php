<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class NewUserController  extends Controller
{
    public function newUser(Request $request)
    {
        $users = $request->all();
        foreach ($users as $value) {
            $value['id'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9);
            $value['password'] = Hash::make(12345678);
            $value['password_text'] = '12345678';
            $user = User::create($value);
            SendEmailJob::dispatch($user);
        }
    }
}
