<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\ORM\Mapping        as ORM;
use Gedmo\Mapping\Annotation    as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createDate;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updateDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $online;

    /**
     * @ORM\ManyToOne(targetEntity=Template::class, inversedBy="pages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $template;

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    /**
     * @param string|null $subTitle
     * @return $this
     */
    public function setSubTitle(?string $subTitle): self
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $template): self
    {
        $this->template = $template;

        return $this;
    }
}
