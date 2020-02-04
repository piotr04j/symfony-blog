<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=4096)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles() {
        return ['ROLE_USER'];
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSalt() {
        // TODO: Implement getSalt() method.
    }

    public function setUsername(string $username) {
        $this->username = $username;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getUsername() {
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
    public function eraseCredentials() {
        $this->password = null;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function isEqualTo(UserInterface $user)
    {

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}
