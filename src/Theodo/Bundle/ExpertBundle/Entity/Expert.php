<?php

namespace Theodo\Bundle\ExpertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expert
 * 
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 * @ORM\Entity()
 */
class Expert
{
    /**
     * @var Integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *
     * @ORM\Column(type="string", length=255, name="first_name")
     */
    protected $firstName;

    /**
     * @var String
     *
     * @ORM\Column(type="string", length=255, name="last_name")
     */
    protected $lastName;

    /**
     * @var String
     *
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $username;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param String $firstName
     *
     * @return Expert
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param String $lastName
     *
     * @return Expert
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param String $username
     *
     * @return Expert
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return String
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->lastName.' '.$this->firstName;
    }
}
