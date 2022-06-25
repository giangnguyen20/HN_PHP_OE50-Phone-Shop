<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderNotifications;
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
    
    public function getUser($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getAllUser()
    {
        return $this->model->orderBy('id', 'DESC')->paginate(config('auth.orderPagination'));
    }

    public function updateStatusUser($id, $data)
    {
        $user = $this->model->findOrFail($id);

        $user->status = $data;
        $user->update();
    }

    public function markAsReadtNotificationById($id)
    {
        return Auth::user()->notifications->find($id)->markAsRead();
    }

    public function getDataNotificationById($id)
    {
        return Auth::user()->notifications->find($id)->data['id'];
    }

    public function markAsReadtAllNotification()
    {
        return Auth::user()->notifications->markAsRead();
    }

    public function setNotification($id, $data)
    {
        $user = $this->model->findOrFail($id);

        return $user->notify(new OrderNotifications($data));
    }

    public function getIdNotificationWithUser($id)
    {
        $user = $this->model->findOrFail($id);

        return $user->notifications->first()->id;
    }
}
