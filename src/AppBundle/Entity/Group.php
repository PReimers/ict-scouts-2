<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;

/**
 * Groups.
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 */
class Group extends Role
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50, unique=true)
     */
    protected $role;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="groups", cascade={"all"})
     */
    private $users;

    /**
     * Group constructor.
     *
     * @param string $name
     * @param string $role
     */
    public function __construct(string $name, string $role)
    {
        $this->name = $name;
        $this->users = new ArrayCollection();
        parent::__construct($role);
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Group
     */
    public function setName(string $name): Group
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set role.
     *
     * @param string $role
     *
     * @return Group
     */
    public function setRole(string $role): Group
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Add user.
     *
     * @param User $user
     */
    public function addUser(User $user): void
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }
    }

    /**
     * Remove user.
     *
     * @param User $user
     */
    public function removeUser(User $user): void
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users.
     *
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
