<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User.
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(name="google_id", type="string", length=255, unique=true)
     */
    private $googleId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", length=255, nullable=true)
     */
    private $accessToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="access_token_expires_at", type="datetime", nullable=true)
     */
    private $accessTokenExpiresAt;

    /**
     * @var Person
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Person", mappedBy="user")
     */
    private $person;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group", inversedBy="users", cascade={"all"})
     * @ORM\JoinTable(
     *     name="user_has_groups", joinColumns={
     *          @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     *     }
     * )
     */
    private $groups;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TalentNote", mappedBy="user")
     */
    private $talentNotes;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->talentNotes = new ArrayCollection();
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
     * Set googleId.
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId(string $googleId): User
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId.
     *
     * @return string
     */
    public function getGoogleId(): string
    {
        return $this->googleId;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set accessToken.
     *
     * @param string $accessToken
     *
     * @return User
     */
    public function setAccessToken(string $accessToken): User
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken.
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Set accessTokenExpiresAt.
     *
     * @param \DateTime $accessTokenExpiresAt
     *
     * @return User
     */
    public function setAccessTokenExpiresAt(\DateTime $accessTokenExpiresAt): User
    {
        $this->accessTokenExpiresAt = $accessTokenExpiresAt;

        return $this;
    }

    /**
     * Get accessTokenExpiresAt.
     *
     * @return \DateTime
     */
    public function getAccessTokenExpiresAt(): \DateTime
    {
        return $this->accessTokenExpiresAt;
    }

    /**
     * Set person.
     *
     * @param Person $person
     *
     * @return User
     */
    public function setPerson(Person $person): User
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person.
     *
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * Add group to user.
     *
     * @param Group $group
     */
    public function addGroup(Group $group): void
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
        }
    }

    /**
     * Remove group from user.
     *
     * @param Group $group
     */
    public function removeGroup(Group $group): void
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups of this user.
     *
     * @return Collection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * Add talent note.
     *
     * @param TalentNote $talentNote
     */
    public function addTalentNote(TalentNote $talentNote): void
    {
        if (!$this->talentNotes->contains($talentNote)) {
            $this->talentNotes->add($talentNote);
        }
    }

    /**
     * Remove talent note.
     *
     * @param TalentNote $talentNote
     */
    public function removeTalentNote(TalentNote $talentNote): void
    {
        $this->talentNotes->removeElement($talentNote);
    }

    /**
     * Get talent notes.
     *
     * @return Collection|null
     */
    public function getTalentNotes(): ?Collection
    {
        return $this->talentNotes;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): string
    {
        return $this->getEmail();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void
    {
        return;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getUsername();
    }
}
