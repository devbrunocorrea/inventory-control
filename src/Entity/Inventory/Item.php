<?php

namespace App\Entity\Inventory;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="inventory_items")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="items")
     */
    private $user;

    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }
    
    public function getId() : int
    {
        return $this->id;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        
        return $this;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setUser(?User $user) : self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}