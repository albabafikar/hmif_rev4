<?php

/**
 * Created by PhpStorm.
 * User: jimmy
 * Date: 11/03/16
 * Time: 18:27
 */

use Behat\Behat\Context\Context;
use Symfony\Component\EventDispatcher\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Jimmy\hmifOfficial\Domain\Entity\User;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;

class FeatureContext implements Context, SnippetAcceptingContext
{

    private $user;

//    public function userSudahTeregistrasiDiSystemDenganStatus($value)
//    {
//        $this->user = $value;
//    }

    /**
     * @Given User sudah teregistrasi di system dengan status :arg1
     */
    public function userSudahTeregistrasiDiSystemDenganStatus($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When user dengan status :arg1 melakukan login
     */
    public function userDenganStatusMelakukanLogin($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then user dapat memasuki sistem
     */
    public function userDapatMemasukiSistem()
    {
        throw new PendingException();
    }

}