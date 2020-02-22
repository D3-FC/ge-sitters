<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkerCreateUpdateRequest;
use App\User;
use App\Worker;
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

        return $this->me()->becomeWorker($request->all());
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

        /** @var Worker $worker */
        $worker = $this->me()->worker;

        $worker->updateFromParams($request->all());

        return $worker;
    }

    public function get(Request $request)
    {
        if ($this->me()->is_admin) {
            abort(404);//TODO: implement
        }

        if ($this->me()->is_worker) {
            return $this->me()->worker->loadPrices()->loadSchedules()->loadUser();
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
