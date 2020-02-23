<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Http\Middleware\ValidateIsClient;
use App\Http\Requests\AdvertisementCreateRequest;
use App\User;

class AdvertisementController extends Controller
{
    public function create(AdvertisementCreateRequest $request): Advertisement
    {
        $this->middleware(ValidateIsClient::class);

        return $this->me()->client->createAdvertisement($request->all());
    }

    private function me(): User
    {
        /** @var User $user */
        $user = \Auth::user();

        return $user;
    }
}
