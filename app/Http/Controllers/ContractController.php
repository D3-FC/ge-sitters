<?php

namespace App\Http\Controllers;

use App\Contract;
use App\User;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return Contract
     */
    public function create(Request $request): Contract
    {
        $me = $this->me();
        $offerId = $request->input('offer.id');

        if ($me->is_worker) {
            return $me->worker->getOfferById($offerId)->createContract();
        }

        abort(404);

        return null;
    }

    private function me(): User
    {
        /** @var User $u */
        $u = \Auth::user();

        return $u;
    }
}
