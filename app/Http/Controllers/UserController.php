<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\ResponseFromFile;

#[Group('User', '用户')]
class UserController extends Controller
{
    #[Endpoint('列表')]
    #[ResponseFromFile('responses/user/index.json')]
    #[ResponseFromApiResource(UserCollection::class, User::class, paginate: 10)]
    public function index(Request $request)
    {
        $users = User::filter($request->all())->paginate(10);

        return $this->paginate(new UserCollection($users));
    }

    #[Endpoint('创建')]
    public function store(UserRequest $request, User $user)
    {
        $user->fill($request->validated());
        $user->save();

        return $this->success();
    }

    #[Endpoint('详情')]
    #[ResponseFromFile('responses/user/user.json')]
    #[ResponseFromApiResource(UserResource::class, User::class)]
    public function show(User $user)
    {
        return $this->success(new UserResource($user->load('topics')));
    }

    #[Endpoint('更新')]
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return $this->success();
    }
}
