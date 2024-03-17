<?php

namespace App\Http\Controllers;

use App\Data\AuthTokenData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Group;

#[Group('Auth', '用户认证')]
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        if (! $token = Auth::guard('api')->attempt([
                'name' => $request->name,
                'password' => $request->password,
            ]))
        {
            return $this->error('账号密码错误');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->success(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->success();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->success(new AuthTokenData(
            access_token: $token,
            token_type: 'bearer',
            expires_in: auth()->factory()->getTTL() * 60,
        ));
    }

    public function modifyPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required',
        ]);

        $user = auth()->user();
        if (! Hash::check($request->old_password, $user->getAuthPassword())) {
            return $this->error('密码错误');
        }

        $user->password = $request->password;
        $user->save();

        return $this->success();
    }
}
