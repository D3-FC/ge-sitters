<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceCreateRequest;
use App\Price;
use App\User;
use Auth;
use Exception;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * @var User
     */
    private $me;

    public function __construct()
    {
        $this->me = Auth::user();
    }

    public function create(PriceCreateRequest $request)
    {
        if ($this->me->is_admin) {
            abort(404); //TODO: implement
        }
        if (!$this->me->is_worker) {
            abort(403);
        }

        return $this->me->worker->createSchedule($request->all());
    }

    /**
     * @param  Request|Price  $request
     *
     * @return mixed
     * @throws Exception
     */
    public function delete(Request $request): void
    {
        $this->me->worker->bulkDeleteSchedule($request->id);
    }
}
