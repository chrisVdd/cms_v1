<?php

namespace App\Entity;

use App\Repository\ConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfigurationRepository::class)
 */
class Configuration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_webiste_open;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_website_protected;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsWebisteOpen(): ?bool
    {
        return $this->is_webiste_open;
    }

    public function setIsWebisteOpen(bool $is_webiste_open): self
    {
        $this->is_webiste_open = $is_webiste_open;

        return $this;
    }

    public function getIsWebsiteProtected(): ?bool
    {
        return $this->is_website_protected;
    }

    public function setIsWebsiteProtected(bool $is_website_protected): self
    {
        $this->is_website_protected = $is_website_protected;

        return $this;
    }
}
