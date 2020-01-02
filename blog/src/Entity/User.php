<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
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

    public function getPassword() : string {
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
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password) {
        $this->password = $password;
    }
}
