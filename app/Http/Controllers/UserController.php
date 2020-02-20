<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequest;
use App\User;
use Auth;
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
}
