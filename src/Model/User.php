<?php
namespace App\Model;

class User{

    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;
    private $role;

    public function getId(): ?int{
        return $this->id;
    }

    public function setId(int $id): self{
        $this->id = $id;
        return $this;
    }


    public function getUsername(): ?string{
        return $this->username;
    }

    public function setUsername(string $username): self{
        $this->username = $username;
        return $this;
    }


    public function getPassword(): ?string{
        return $this->password;
    }

    public function setPassword(string $password): self{
        $this->password = $password;
        return $this;
    }


    public function getRole(): ?string{
        return $this->role;
    }

    public function setRole(string $role): self{
        $this->role = $role;
        return $this;
    }
}