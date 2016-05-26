<?php
/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 11/03/16
 * Time: 18:41
 */

namespace spec\Jimmy\hmifOfficial\Domain\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UsersSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Jimmy\hmifOfficial\Domain\Entity\User');
    }

    public function it_can_create_new_user()
    {
        $this->beConstructedCreate('username','password','role');
        $this->getUsername()->shoudlReturn('username');
        $this->getRole()->shouldReturn('role');
    }
}