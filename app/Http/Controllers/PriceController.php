<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceCreateRequest;
use App\Price;
use Exception;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function create(PriceCreateRequest $request)
    {
        return \Auth::user()->worker->createPrice($request->all());
    }

    /**
     * @param  Request|Price  $request
     *
     * @return mixed
     * @throws Exception
     */
    public function delete(Request $request)
    {
        return \Auth::user()->worker->bulkDeletePrice($request->id);
    }
}
