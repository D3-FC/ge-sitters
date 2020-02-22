<?php

namespace App\Http\Controllers;

use App\Enums\WorkerRelation;
use App\Http\Requests\WorkerCreateUpdateRequest;
use App\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function create(WorkerCreateUpdateRequest $request)
    {
        $me = \Auth::user();

        if ($me->is_admin) {
            abort(404);//TODO: implement
        }

        if ($me->is_worker) {
            abort(403, 'You are already a worker');
        }

        return $me->becomeWorker($request->all());
    }

    public function update(WorkerCreateUpdateRequest $request)
    {
        $me = \Auth::user();

        if ($me->is_admin) {
            abort(404);//TODO: implement
        }

        /** @var Worker $worker */
        $worker = $me->worker;

        $worker->updateFromParams($request->all());

        return $worker;
    }

    public function get(Request $request)
    {
        $me = \Auth::user();

        if ($me->is_admin) {
            abort(404);//TODO: implement
        }

        if ($me->is_worker) {
            return $me->worker->load(WorkerRelation::PRICES, WorkerRelation::SCHEDULES);
        }

        return abort(404);
    }


    public function getMany(Request $request)
    {
        $me = \Auth::user();

        if (!$me->is_admin) {
            abort(404);
        }

        //TODO: implement for admins
    }
}
