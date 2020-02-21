<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::registerSaveFromRequest($request);

        event(new Registered($user));

        Auth::guard()->login($user);

        return $user;
    }

    /**
     * @param  User  $user
     *
     * @param  UserUpdateRequest  $request
     *
     * @return User
     * @throws AuthorizationException
     */
    public function update(UserUpdateRequest $request)
    {
        $user = User::findOrFail($request->input('id'));

        $this->authorize('view', $user);

        $user->updateFromArray($request->all())->save();

        return $user;
    }
}
