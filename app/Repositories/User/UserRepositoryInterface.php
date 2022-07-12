<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getAdmins();
    
    public function getUser($id);

    public function getAllUser();

    public function updateStatusUser($id, $data);

    public function markAsReadtNotificationById($id);

    public function getDataNotificationById($id);

    public function markAsReadtAllNotification();

    public function setNotification($id, $data);

    public function getIdNotificationWithUser($id);

    public function findUserByEmail($email);
}
