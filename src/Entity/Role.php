<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Client", inversedBy="clientRoles")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Restaurant", inversedBy="restaurantRoles")
     */
    private $restaurateurs;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->restaurateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Client $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(Client $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurateurs(): Collection
    {
        return $this->restaurateurs;
    }

    public function addRestaurateur(Restaurant $restaurateur): self
    {
        if (!$this->restaurateurs->contains($restaurateur)) {
            $this->restaurateurs[] = $restaurateur;
        }

        return $this;
    }

    public function removeRestaurateur(Restaurant $restaurateur): self
    {
        if ($this->restaurateurs->contains($restaurateur)) {
            $this->restaurateurs->removeElement($restaurateur);
        }

        return $this;
    }
}
