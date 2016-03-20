<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 11/03/16
 * Time: 14:31
 */

namespace Jimmy\hmifOfficial\Domain\Services;

use Jimmy\hmifOfficial\Domain\Entity\User;
class UserPasswordMatcher
{

    private $rawPassword;

    private $user;

    public function __construct($rawPassword, User $user)
    {
        $this->rawPassword = $rawPassword;
        $this->user = $user;
    }

    public function match()
    {
        return password_verify($this->rawPassword, $this->user->getPassword());
    }
}