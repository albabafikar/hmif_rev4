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
     * @return News
     */
    public function findById($id);

    /**
     * @param $username
     * @return News
     */
    public function findByUsername($username);

    /**
     * @param $featured
     * @return News
     */
    public function findByFeaturedStatus($featured);
}