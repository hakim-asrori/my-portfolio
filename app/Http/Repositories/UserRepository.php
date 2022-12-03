<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\UserInterface;
use App\Http\Repositories\Repository;
use App\Models\User;

class UserRepository extends Repository implements UserInterface
{
    /** @var User */
    protected $user;

    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
    }

    // Write something awesome :)
}
