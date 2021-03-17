<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Gedmo\Loggable()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Gedmo\Versioned
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=180)
     * @Gedmo\Versioned
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     */
    private ?string $password;

    /**
     * @ORM\Column(type="json")
     * @Gedmo\Versioned
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isTest;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="author", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToOne(targetEntity=Profil::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $profil;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
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
        return (string) $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
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

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
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
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * @return bool|null
     */
    public function getIsTest(): ?bool
    {
        return $this->isTest;
    }

    /**
     * @param bool $isTest
     * @return $this
     */
    public function setIsTest(bool $isTest): self
    {
        $this->isTest = $isTest;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        // unset the owning side of the relation if necessary
        if ($profil === null && $this->profil !== null) {
            $this->profil->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($profil !== null && $profil->getUser() !== $this) {
            $profil->setUser($this);
        }

        $this->profil = $profil;

        return $this;
    }
}
