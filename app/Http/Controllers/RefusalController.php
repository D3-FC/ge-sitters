<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RefusalController extends Controller
{
    public function create(Request $request)
    {
        /** @var User $me */
        $me = \Auth::user();
        if(!$me->is_worker){
            abort(404);
        }

        return $me->worker->getOfferById($request->input('offer.id'))->refuse();
    }
}
