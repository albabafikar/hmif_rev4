<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 11/03/16
 * Time: 14:28
 */

namespace Jimmy\hmifOfficial\Domain\Repository;

use Jimmy\hmifOfficial\Domain\Contracts\Repository\UserRepositoryInterface;
use Jimmy\hmifOfficial\Domain\Entity\User;
class ArrayUserRepository implements UserRepositoryInterface
{

    public function findById($id)
    {
        return User::create('user','password',0);
    }

    public function findByUsername($username)
    {
        return User::create('user','password',0);
    }

    public function findByStatus($status)
    {
        return User::create('user','password',0);
    }
}