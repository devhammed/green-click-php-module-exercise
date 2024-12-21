<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Models\User;
use Modules\User\Http\Resources\UserResource;

class UserController
{
    public function index(): mixed
    {
        return view('users', [
            'users' => User::all(),
        ]);
    }

    public function enable(User $user): UserResource
    {
        $user->update([
            'enabled' => true,
        ]);

        return new UserResource($user);
    }

    public function disable(User $user): UserResource
    {
        $user->update([
            'enabled' => false,
        ]);

        return new UserResource($user);
    }
}
