<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 16/03/16
 * Time: 14:41
 */

namespace Jimmy\hmifOfficial\Domain\Contracts\Repository;

use Jimmy\hmifOfficial\Domain\Entity\News;

/**
 * Interface NewsRepositoryInterface
 * @package Jimmy\hmifOfficial\Domain\Contracts\Repository
 */
interface NewsRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param $username
     * @return mixed
     */
    public function findByUsername($username);
}