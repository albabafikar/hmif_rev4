<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 13/03/16
 * Time: 21:31
 */

namespace Jimmy\hmifOfficial\Domain\Entity;

/**
 * Class News
 * @package Jimmy\hmifOfficial\Domain\Entity
 * @Entity(repositoryClass="Jimmy\hmifOfficial\Domain\Repository\DoctrineNewsRepository")
 * @HasLifecycleCallbacks
 * @Table(name="news")
 */
class News
{
    /**
     * @id
     * @Column(type="integer", name="news_id")
     * @GeneratedValue
     * @var int
     */
    private $newsId;

    /**
     * @Column(type="string", length=255, nullable=false)
     * @var string
     */
    private $title;

    /**
     * @Column(type="string", length=255, nullable=false)
     * @var string
     */
    private $content;

    /**
     * @Column(type="datetime", name="created_at", nullable=false)
     * @var \Datetime
     */
    private $createdAt;

    /**
     * @Column(type="datetime", name="update_at", nullable=true)
     * @var \Datetime
     */
    private $updatedAt;

    /**
     * @Column(type="string", length=128, nullable=false)
     * @var string
     */
    private $username;

    /**
     * @Column(name="featured", type="integer", nullable=false)
     * @var int
     */
    private $featured;


    /**
     * @param $title
     * @param $content
     * @param $username
     * @return News
     */
    public static function create($title, $content, $username)
    {
        $newsInfo = new News();

        $newsInfo->setTitle($title);
        $newsInfo->setContent($content);
        $newsInfo->setUsername($username);
        $newsInfo->setFeatured(0);
        $newsInfo->setCreatedAt(new \DateTime());

        return $newsInfo;
    }

    /**
     * @return int
     */
    public function getNewsId()
    {
        return $this->newsId;
    }

    /**
     * @param $newsId
     */
    public function setNewsId($newsId)
    {
        $this->newsId = $newsId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return integer
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * @param $featured
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    }

    /**
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @PrePersist
     * @return void
     */
    public function timestampableCreateEvent()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @PrePersist
     * @return void
     */
    public function timestampableUpdateEvent()
    {
        $this->updatedAt = new \DateTime();
    }
}