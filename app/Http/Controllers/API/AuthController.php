<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;

class AuthController extends Controller
{
    /**
     * @param AuthRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(AuthRequest $request)
    {
        /** @var User $user */

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => 'Введен не верный пароль'], 401);
        }

        if (!$user->email_verified_at) {
            return response()->json(['errors' => 'Подтвердите вашу почту'], 500);
        } else {
            return response()->json([
                'token' => $user->createToken($request->device_name)->plainTextToken,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'id' => $user->id,
                'theme' => $user->theme,
                'header_type' => $user->header_type,
                'projects_roles' => json_decode($user->projects_roles)
            ]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json('logout complete.', 200);
    }

    /**
     * @return JsonResponse
     */
    public function revocation()
    {
        auth()->user()->tokens()->delete();
        return response()->json('revocation complete.', 200);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return response()->json([
            'url' => Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);

//        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return
     */
    public function handleProviderCallback($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail(),
            ],
            [
                'email_verified_at' => '12',
                'name' => $user->getName(),
                'password' => Hash::make('12345678')
            ]
        );
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );

        return response()->json([
            'user' => $userCreated,
            'access_token' => $userCreated->createToken('google-token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);

//        $token = $userCreated->createToken('Token Name')->accessToken;
//        return redirect()->route('login',[$userCreated])->with(['Access-Token' => $token]);
//        return response()->json([$userCreated, $token], 200, ['Access-Token' => $token]);
    }

    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }
    }

}
