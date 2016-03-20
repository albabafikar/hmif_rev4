<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 11/03/16
 * Time: 14:25
 */

namespace Jimmy\hmifOfficial\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use Jimmy\hmifOfficial\Domain\Contracts\Repository\UserRepositoryInterface;
class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{

    public function findById($id)
    {
        return $this->find($id);
    }

    public function findByUsername($username)
    {
        return $this->findOneBy(['username' => $username]);
    }

    public function findByStatus($status)
    {
        return $this->find($status);
    }
}