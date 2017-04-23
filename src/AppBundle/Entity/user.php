<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class user implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", unique=true)
     */
    private $nick;

    /**
     *@ORM\Column(type="string")
     */
    private $pass;


    public function getid()
    {
        return $this->id;
    }

      public function getnick()
    {
        return $this->nick;
    }

    public function getpass()
    {
        return $this->pass;
    }

    public function setpass($pass)
    {
        $this->pass= $pass;
    }

    public function setnick($nick)
    {
        $this->nick = $nick ;
    }


    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    public function getSalt()
    {
        return null ;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function getPassword()
    {
        return $this->pass;
    }

    public function getUsername()
    {
        return $this->nick;
    }

}