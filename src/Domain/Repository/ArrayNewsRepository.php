<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 16/03/16
 * Time: 14:49
 */

namespace Jimmy\hmifOfficial\Domain\Repository;

use Jimmy\hmifOfficial\Domain\Contracts\Repository\NewsRepositoryInterface;
use Jimmy\hmifOfficial\Domain\Entity\News;
class ArrayNewsRepository implements NewsRepositoryInterface
{
    public function findById($id)
    {
        return News::create('lorem','document\lorem.md','dito');
    }

    public function findByUsername($username)
    {
        return News::create('lorem','document\lorem.md','dito');
    }

}