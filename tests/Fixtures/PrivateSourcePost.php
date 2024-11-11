<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Fixtures;

/**
 * @author Jorge Garcia Ramos <jorgegr89@gmail.com>
 */
class PrivateSourcePost
{
    /** @param SourceComment[] $comments */
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $description = null,
        private ?string $author = null,
        private ?array $comments = null,
    ) {
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAuthor(): mixed
    {
        return $this->author;
    }

    public function setAuthor(mixed $author): void
    {
        $this->author = $author;
    }

    /**
     * @return ?SourceComment[]
     */
    public function getComments(): ?array
    {
        return $this->comments;
    }

    /**
     * @param SourceComment[] $comments
     */
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}
