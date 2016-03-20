<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 11/03/16
 * Time: 15:00
 */

namespace Jimmy\hmifOfficial\Domain\Entity;

/**
 * Class User
 * @package Jimmy\hmifOfficial\Domain\Entity
 * @Entity(repositoryClass="Jimmy\hmifOfficial\Domain\Repository\DoctrineUserRepository")
 * @HasLifecycleCallbacks
 */
class User
{

    /**
     * @id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", length=128, nullable=false)
     * @var string
     */
    private $username;

    /**
     * @Column(type="string", length=128, nullable=false)
     * @var string
     */
    private $password;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $role;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $status;

    /**
     * @Column(type="datetime", name="created_at", nullable=false)
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @Column(type="datetime", name="last_login", nullable=true)
     * @var \DateTime
     */
    private $lastLogin;

    public function __construct()
    {

    }

    /**
     * @param $username
     * @param $password
     * @param $role
     * @return User
     */
    public static function create($username, $password, $role)
    {
        $users = new User();

        $users->setUsername($username);
        $users->setPassword($password);
        $users->setRole($role);
        $users->setCreatedAt(new \DateTime());
        $users->setStatus(0);

        return $users;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setPasswordNonHash($password)
    {
        $this->password = $password;
    }
    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return \DateTime
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
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
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
    public function timestampableLastLoginEvent()
    {
        $this->lastLogin = new \DateTime();
    }

}