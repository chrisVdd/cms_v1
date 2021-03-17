<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $City;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updateDate;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="profil", cascade={"persist", "remove"})
     */
    private $user;

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
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return $this
     */
    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    /**
     * @param \DateTimeInterface $birthdate
     * @return $this
     */
    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->Country;
    }

    /**
     * @param string $Country
     * @return $this
     */
    public function setCountry(string $Country): self
    {
        $this->Country = $Country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->City;
    }

    /**
     * @param string $City
     * @return $this
     */
    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    /**
     * @param \DateTimeInterface $createDate
     * @return $this
     */
    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    /**
     * @param \DateTimeInterface $updateDate
     * @return $this
     */
    public function setUpdateDate(\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
