<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UsersProjectsRoleResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request)
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
//        $input['device_name'] = request()->headers->get('User-Agent');
        $input['device_name'] = $request->device_name;
        $user = User::create($input);

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * @param AuthRequest $request
     * @return JsonResponse
     */
    public function login(AuthRequest $request)
    {
        /** @var User $user */
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }
        $user->tokens()->where('name', request()->headers->get('User-Agent'))->delete();

        $roles = $user->roles()->with('project')->get();
        $ret = [];
        foreach ($roles as $role) {
            $ret[$role->project->key] = json_decode($role->roles);
        }

        return response()->json([
//            'token' => $user->createToken(request()->headers->get('User-Agent'))->plainTextToken,
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'id' => $user->id,
            'theme' => $user->theme,
            'header_type' => $user->header_type,
//            'projects_roles' => json_decode($user->projects_roles),
            'projects_roles' => $ret
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
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

}
