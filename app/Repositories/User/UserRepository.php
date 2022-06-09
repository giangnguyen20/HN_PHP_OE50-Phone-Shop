<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getAdmins()
    {
        $users =  $this->model->where('role_id', config('auth.roles.admin'))->get();

        return $users;
    }
}
