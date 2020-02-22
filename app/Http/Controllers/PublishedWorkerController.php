<?php

namespace App\Http\Controllers;

use App\Enums\PublishedWorkerRelation;
use App\Enums\WorkerRelation;
use App\Http\Middleware\ValidateIsAdmin;
use App\PublishedWorker;
use App\Services\Relation;
use App\Worker;
use Exception;
use Illuminate\Http\Request;

class PublishedWorkerController extends Controller
{

    public function create(Request $request): PublishedWorker
    {
        $this->middleware(ValidateIsAdmin::class);

        /** @var Worker $worker */
        $worker = Worker::findOrFail($request->input('worker.id'));

        return $worker->publish();
    }

    /**
     * @param  Request|Worker  $request
     *
     * @throws Exception
     */
    public function delete(Request $request): void
    {
        $this->middleware(ValidateIsAdmin::class);

        PublishedWorker::deleteById($request->id);
    }


    /**
     * @param  Request|PublishedWorker  $request
     * @param  Relation  $r
     *
     * @return PublishedWorker
     */
    public function get(Request $request, Relation $r): PublishedWorker
    {

        /** @var PublishedWorker $pw */
        $pw = PublishedWorker::findOrFail($request->id)->load([
            PublishedWorkerRelation::WORKER.".".WorkerRelation::PRICES,
            PublishedWorkerRelation::WORKER.".".WorkerRelation::SCHEDULES,
            PublishedWorkerRelation::WORKER.".".WorkerRelation::USER,
        ]);

        return $pw;

    }

    /**
     * @param  Request|PublishedWorker  $request
     *
     * @return PublishedWorker
     */
    public function getMany(Request $request)
    {
        /** @var PublishedWorker $pw */
        $pw = PublishedWorker::with([
            PublishedWorkerRelation::WORKER.".".WorkerRelation::USER,
        ])
            ->paginate(50);

        return $pw;

    }
}
