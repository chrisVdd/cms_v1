<?php

namespace App\Entity;

use App\Repository\PostReferenceRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PostReferenceRepository::class)
 * @Vich\Uploadable()
 */
class PostReference
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="postReferences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @Vich\UploadableField(mapping="private_post_reference", fileNameProperty="filename")
     * @var File|null
     */
    private $file;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface|null
     */
    private $updateDate;

    /**
     * PostReference constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Post|null
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * @param Post|null $post
     * @return $this
     */
    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file = null)
    {
        $this->file = $file;

        if (null !== $file) {
            $this->updateDate = new \DateTimeImmutable();
        }
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdateDate(): ?DateTimeInterface
    {
        return $this->updateDate;
    }

    /**
     * @param DateTimeInterface|null $updateDate
     */
    public function setUpdateDate(?DateTimeInterface $updateDate): void
    {
        $this->updateDate = $updateDate;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return UploadHelper::POST_REFERENCE.'/'.$this->getFilename();
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->getFilename();
    }
}
