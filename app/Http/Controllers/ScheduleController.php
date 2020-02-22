<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceCreateRequest;
use App\Price;
use Exception;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function create(PriceCreateRequest $request)
    {
        $me = \Auth::user();

        if ($me->is_admin) {
            abort(404); //TODO: implement
        }
        if (!$me->is_worker) {
            abort(403);
        }

        return $me->worker->createSchedule($request->all());
    }

    /**
     * @param  Request|Price  $request
     *
     * @return mixed
     * @throws Exception
     */
    public function delete(Request $request): void
    {
        \Auth::user()->worker->bulkDeleteSchedule($request->id);
    }
}
