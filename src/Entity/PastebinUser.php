<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class PastebinUser implements UserInterface, EquatableInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     * @Assert\Email(
     *          checkMX = true
     *     )
     * @Assert\NotBlank
     */
    private $email;

    /** @ORM\Column(type="string", length=64) */
    private $hash;

    /** @ORM\OneToMany(targetEntity="Paste", mappedBy="author") */
    private $pastes;

    /**
     * @ORM\ManyToMany(targetEntity="Paste")
     * @ORM\JoinTable(
     *     name="Favourites",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="paste_id", referencedColumnName="id")}
     *     )
     */
    private $favourites;

    /** @Assert\NotBlank */
    private $plainPassword;

    public function __construct()
    {
        $this->pastes = new ArrayCollection();
    }

    public function isEqualTo(UserInterface $user)
    {
        if($this->getUsername() !== $user->getUsername())
            return false;

        if($this->getPassword() !== $user->getPassword())
            return false;

        return true;
    }

    public function getRoles()
    {
        //this table only holds normal users
        return array('ROLE_USER');
    }

    public function getPassword()
    {
        return $this->hash;
    }

    public function getSalt()
    {
        //we don't store salt in this implementation
        return null;
    }

    public function getUsername()
    {
        //email doubles as username
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

}
