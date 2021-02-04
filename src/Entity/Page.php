<?php

namespace App\Entity;

use App\Repository\PageRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping        as ORM;
use Gedmo\Mapping\Annotation    as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @UniqueEntity(fields={"slug"}, errorPath="title", message="page.slug_unique")
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $online;

    /**
     * @ORM\ManyToOne(targetEntity=Template::class, inversedBy="pages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToMany(targetEntity=Widget::class, mappedBy="pages")
     * @ORM\OrderBy({"name": "ASC"})
     */
    private $widgets;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->widgets = new ArrayCollection();
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
     * @return DateTimeInterface|null
     */
    public function getCreateDate(): ?DateTimeInterface
    {
        return $this->createDate;
    }

    /**
     * @param DateTimeInterface $createDate
     * @return $this
     */
    public function setCreateDate(DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdateDate(): ?DateTimeInterface
    {
        return $this->updateDate;
    }

    /**
     * @param DateTimeInterface $updateDate
     * @return $this
     */
    public function setUpdateDate(DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getOnline(): ?bool
    {
        return $this->online;
    }

    /**
     * @param bool $online
     * @return $this
     */
    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    /**
     * @return Template|null
     */
    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    /**
     * @param Template|null $template
     * @return $this
     */
    public function setTemplate(?Template $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection|Widget[]
     */
    public function getWidgets(): Collection
    {
        return $this->widgets;
    }

    public function addWidget(Widget $widget): self
    {
        if (!$this->widgets->contains($widget)) {
            $this->widgets[] = $widget;
            $widget->addPage($this);
        }

        return $this;
    }

    public function removeWidget(Widget $widget): self
    {
        if ($this->widgets->removeElement($widget)) {
            $widget->removePage($this);
        }

        return $this;
    }
}
