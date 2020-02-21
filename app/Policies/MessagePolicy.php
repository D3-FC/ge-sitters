<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;


    public function create()
    {
        return true; // TODO: implement;
    }
}
