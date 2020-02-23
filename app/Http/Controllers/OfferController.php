<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Http\Middleware\ValidateIsClient;
use App\Offer;
use App\PublishedWorker;
use App\User;
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
}
