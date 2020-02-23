<?php

namespace App\Http\Controllers;

use App\Enums\WorkerRelation;
use App\Http\Requests\WorkerCreateUpdateRequest;
use App\User;
use Illuminate\Http\Request;

class WorkerController extends Controller
{

    public function create(WorkerCreateUpdateRequest $request)
    {
        if ($this->me()->is_admin) {
            abort(404);//TODO: implement
        }

        if ($this->me()->is_worker) {
            abort(403, 'You are already a worker');
        }

        return $this->me()->becomeWorker($request->all())->load(WorkerRelation::USER);
    }

    public function me(): User
    {
        /** @var User $me */
        $me = \Auth::user();

        return $me;
    }

    public function update(WorkerCreateUpdateRequest $request)
    {
        if ($this->me()->is_admin) {
            abort(404);//TODO: implement
        }

        $this->me()->worker->updateFromParams($request->all());

        return $this->me()->worker;
    }

    public function get(Request $request)
    {
        if ($this->me()->is_admin) {
            abort(404);//TODO: implement
        }

        if ($this->me()->is_worker) {
            return $this->me()->worker->load([
                WorkerRelation::USER,
                WorkerRelation::SCHEDULES,
                WorkerRelation::PRICES,
                WorkerRelation::PUBLISHED_WORKER,
            ]);
        }

        return abort(404);
    }

    public function getMany(Request $request)
    {
        if (!$this->me()->is_admin) {
            abort(404);
        }

        //TODO: implement for admins
    }
}
