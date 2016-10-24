<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 11/03/16
 * Time: 14:22
 */

namespace Jimmy\hmifOfficial\Domain\Contracts\Repository;

use Jimmy\hmifOfficial\Domain\Entity\User;

interface UserRepositoryInterface
{

    /**
     * @param $id
     * @return User
     */
    public function findById($id);

    /**
     * @param $username
     * @return User
     */
    public function findByUsername($username);

    /**
     * @param $status
     * @return User
     */
    public function findByStatus($status);
}