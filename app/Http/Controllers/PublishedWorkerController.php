<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ValidateIsAdmin;
use App\PublishedWorker;
use App\Worker;
use Exception;
use Illuminate\Http\Request;

class PublishedWorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware(ValidateIsAdmin::class);
    }

    public function create(Request $request): PublishedWorker
    {
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
        PublishedWorker::deleteById($request->id);
    }
}
