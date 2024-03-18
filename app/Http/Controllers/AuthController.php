<?php

namespace App\Http\Controllers;

use App\Data\AuthTokenData;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseField;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\ResponseFromFile;

#[Group('Auth', '用户认证')]
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    #[Endpoint('登录')]
    #[Response([
        'code' => SUCCESS,
        'message' => '请求成功',
        'data' => [
            'access_token' => 'sdfkljHDFHDl3j4lHSDKFHL',
            'token_type' => 'bearer',
            'expires_in' => 7200,
        ]
    ])]
    #[ResponseField('access_token', 'string', '登录成功后返回的token')]
    #[ResponseField('token_type', 'string', 'token类型')]
    #[ResponseField('expires_in', 'int', 'token过期时间')]
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

    #[Endpoint('认证详情')]
    #[ResponseFromFile('responses/user/user.json')]
    #[ResponseFromApiResource(UserResource::class, User::class)]
    public function me()
    {
        return $this->success(auth()->user());
    }

    #[Endpoint('退出')]
    public function logout()
    {
        auth()->logout();

        return $this->success();
    }

    #[Endpoint('刷新token')]
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

    #[Endpoint('修改密码')]
    #[BodyParam('old_password', 'string', '原密码')]
    #[BodyParam('password', 'string', '新密码')]
    #[ResponseFromFile('responses/success.json')]
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
