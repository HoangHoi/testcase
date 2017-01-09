<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\UserRepository as UserRepositoryInterface;
use App\Models\User;
use DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function __construct(User $user)
    {
        parent::__construct();
        $this->model = $user;
    }

    public function model()
    {
        return User::class;
    }

    public function showAll()
    {
        $users = $this->select(['id', 'name', 'email'])->get();

        if ($users['status']) {
            return $users['data']->toArray();
        }

        return [];
    }

}
