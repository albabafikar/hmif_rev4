<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 16/03/16
 * Time: 14:45
 */

namespace Jimmy\hmifOfficial\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use Jimmy\hmifOfficial\Domain\Contracts\Repository\NewsRepositoryInterface;

class DoctrineNewsRepository extends EntityRepository implements NewsRepositoryInterface
{
    public function findById($id)
    {
        return $this->find($id);
    }

    public function findByUsername($username)
    {
        return $this->find(['username' => $username]);
    }
}