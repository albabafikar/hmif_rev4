<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 27/05/16
 * Time: 16:04
 */

namespace Jimmy\hmifOfficial\Domain\Services;

use Jimmy\hmifOfficial\Domain\Entity\News;
class NewsService
{
    public static function changeFeaturedStatus(News $news)
    {
        $status = $news->getFeatured();

        switch ($status) {
            case 0 :
                $news->setFeatured(1);
                break;
            case 1 :
                $news->setFeatured(0);
                break;
        }
    }
}