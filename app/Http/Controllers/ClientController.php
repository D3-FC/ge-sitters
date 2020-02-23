<?php

namespace App\Http\Controllers;

use App\Client;
use App\Enums\ClientRelation;
use App\Http\Requests\WorkerCreateUpdateRequest;
use App\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return Client
     */
    public function create(Request $request)
    {
        if ($this->me()->is_admin) {
            abort(404);//TODO: implement
        }

        if ($this->me()->is_client) {
            abort(403, 'You are already a client');
        }

        return $this->me()->becomeClient()->load(ClientRelation::USER);
    }

    public function me(): User
    {
        /** @var User $me */
        $me = \Auth::user();

        return $me;
    }

}
