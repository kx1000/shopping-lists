<?php

namespace App\Entity;

use App\Repository\ShoppingListItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShoppingListItemRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="search_idx", columns={"name"}, flags={"fulltext"})})
 */
class ShoppingListItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ShoppingList::class, inversedBy="shoppingListItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shoppingList;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFound;

    public function __construct()
    {
        $this->isFound = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShoppingList(): ?ShoppingList
    {
        return $this->shoppingList;
    }

    public function setShoppingList(?ShoppingList $shoppingList): self
    {
        $this->shoppingList = $shoppingList;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsFound(): ?bool
    {
        return $this->isFound;
    }

    public function setIsFound(bool $isFound): self
    {
        $this->isFound = $isFound;

        return $this;
    }
}
