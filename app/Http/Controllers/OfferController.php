<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Enums\OfferRelation;
use App\Http\Middleware\ValidateIsClient;
use App\Offer;
use App\PublishedWorker;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * @param  Request|Advertisement  $request
     *
     * @return Offer
     */
    public function create(Request $request): Offer
    {
        $this->middleware(ValidateIsClient::class);

        /** @var PublishedWorker $pw */
        $pw = PublishedWorker::findOrFail($request->input('published_worker.id'));

        return $this
            ->me()
            ->client
            ->getAdvertisementById($request->input('advertisement.id'))
            ->createOfferTo([], $pw);
    }


    private function me(): User
    {
        /** @var User $me */
        $me = \Auth::user();

        return $me;
    }

    public function getMany(Request $request)
    {
        $me = $this->me();

        if ($me->is_admin) {
            abort(404);
        }


        if ($me->is_client) {
            return $this->paginateOffersQuery($me->client->offers(), $request);
        }

        if ($me->is_worker) {
            return $this->paginateOffersQuery($me->worker->offers(), $request);
        }

        return abort(404);
    }

    /**
     * @param  Offer  $q
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator
     */
    public function paginateOffersQuery($q, Request $request)
    {
        return $q
            ->filteredBy($request->all())
            ->with([
                OfferRelation::CONTRACT,
                OfferRelation::REFUSAL,
                OfferRelation::PUBLISHED_WORKER,
            ])
            ->paginate(50);
    }
}
