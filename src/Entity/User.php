<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(max=180)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingList::class, mappedBy="owner")
     */
    private $shoppingLists;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingList::class, mappedBy="createdBy")
     */
    private $shoppingListsCreatedBy;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->shoppingLists = new ArrayCollection();
        $this->shoppingListsCreatedBy = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getEmail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|ShoppingList[]
     */
    public function getShoppingLists(): Collection
    {
        return $this->shoppingLists;
    }

    public function addShoppingList(ShoppingList $shoppingList): self
    {
        if (!$this->shoppingLists->contains($shoppingList)) {
            $this->shoppingLists[] = $shoppingList;
            $shoppingList->setOwner($this);
        }

        return $this;
    }

    public function removeShoppingList(ShoppingList $shoppingList): self
    {
        if ($this->shoppingLists->removeElement($shoppingList)) {
            // set the owning side to null (unless already changed)
            if ($shoppingList->getOwner() === $this) {
                $shoppingList->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShoppingList[]
     */
    public function getShoppingListsCreatedBy(): Collection
    {
        return $this->shoppingListsCreatedBy;
    }

    public function addShoppingListsCreatedBy(ShoppingList $shoppingListsCreatedBy): self
    {
        if (!$this->shoppingListsCreatedBy->contains($shoppingListsCreatedBy)) {
            $this->shoppingListsCreatedBy[] = $shoppingListsCreatedBy;
            $shoppingListsCreatedBy->setCreatedBy($this);
        }

        return $this;
    }

    public function removeShoppingListsCreatedBy(ShoppingList $shoppingListsCreatedBy): self
    {
        if ($this->shoppingListsCreatedBy->removeElement($shoppingListsCreatedBy)) {
            // set the owning side to null (unless already changed)
            if ($shoppingListsCreatedBy->getCreatedBy() === $this) {
                $shoppingListsCreatedBy->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
    }
}
