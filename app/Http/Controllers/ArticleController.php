<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleCreateRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ArticleController extends Controller
{
    /**
     * @param  ArticleCreateRequest  $request
     *
     * @return mixed
     * @throws AuthorizationException
     */
    public function create(ArticleCreateRequest $request)
    {
        $this->authorize('create', Article::class);

        $a = Article::init($request->all());
        $a->save();

        return $a;
    }

    public function getMany()
    {
        return Article::paginate(50);
    }
}
