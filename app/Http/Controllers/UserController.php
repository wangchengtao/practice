<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::filter($request->all())->paginate(10);

        return $this->paginate(new UserCollection($users));
    }

    public function store(UserRequest $request, User $user)
    {
        $user->fill($request->validated());
        $user->save();

        return $this->success();
    }

    public function show(User $user)
    {
        return $this->success(new UserResource($user->load('topics')));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return $this->success();
    }
}
