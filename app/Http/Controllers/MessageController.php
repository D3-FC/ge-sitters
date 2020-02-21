<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageCreateRequest;
use App\Message;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;

class MessageController extends Controller
{
    /**
     * @param  MessageCreateRequest  $request
     *
     * @return mixed
     * @throws AuthorizationException
     */
    public function create(MessageCreateRequest $request)
    {
        /** @var User $me */
        $me = \Auth::user();
        $m = $me->messageTo($request->all(), User::findOrFail($request->input('to_user.id')));

        $this->authorize('create', $m);

        $m->save();

        return $m;
    }

    public function getMany()
    {
        $me = \Auth::user();

        if ($me->is_admin) {
            return Message::paginate(50);
        }

        return $me->messages()->paginate(50);
    }
}
