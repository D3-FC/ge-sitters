<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;


    public function create(User $user)
    {
        return $user->is_admin;
    }
}
