<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Inventory\Item;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
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
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory\Item", mappedBy="user", indexBy="id")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function setId(int $id) : self
    {
        $this->id;

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

    public function addItem(Item $item) : self
    {
        $this->items[$item->getId()] = $item;

        return $this;
    }
    
    public function getItem(int $id) : Item
    {
        if (!isset($this->items[$id])) {
            throw new \InvalidArgumentException("User does not have this item");
        }

        return $this->items[$id];
    }

    public function setItems(array $items) : self
    {
        $this->items = new ArrayCollection($items);

        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }
}