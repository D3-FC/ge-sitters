<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceCreateRequest;
use App\Http\Requests\ScheduleCreateRequest;
use App\Price;
use App\User;
use Auth;
use Exception;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    public function create(ScheduleCreateRequest $request)
    {
        if ($this->me()->is_admin) {
            abort(404); //TODO: implement
        }
        if (!$this->me()->is_worker) {
            abort(403);
        }

        return $this->me()->worker->createSchedule($request->all());
    }

    private function me()
    {
        /** @var User $u */
        $u = Auth::user();

        return $u;
    }

    /**
     * @param  Request|Price  $request
     *
     * @return mixed
     * @throws Exception
     */
    public function delete(Request $request): void
    {
        $this->me()->worker->bulkDeleteSchedule($request->id);
    }
}
