<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceCreateRequest;
use App\Price;
use App\User;
use App\Worker;
use Exception;
use Illuminate\Http\Request;

class PriceController extends Controller
{

    public function create(PriceCreateRequest $request)
    {
        return $this->me()->worker->createPrice($request->all());
    }

    /**
     * @param  Request|Price  $request
     *
     * @return mixed
     * @throws Exception
     */
    public function delete(Request $request): void
    {
        $this->me()->worker->bulkDeletePrice($request->id);
    }


    private function me()
    {
        /** @var User $me */
        $me = \Auth::user();

        return $me;
    }
}
