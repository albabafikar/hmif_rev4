<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 16/03/16
 * Time: 23:06
 */

namespace Jimmy\hmifOfficial\Domain\Services;

use Jimmy\hmifOfficial\Domain\Entity\User;
class UserServices
{
    public static function changeStatus(User $user)
    {
        $status = $user->getStatus();

        switch ($status) {
            case 0:
                $user->setStatus(1);
                break;
            case 1:
                $user->setStatus(0);
                break;
        }
    }
}