<?php

namespace Retailcrm\AutoMapperBundle\Tests\Fixtures;

/**
 * @author Jorge Garcia Ramos <jorgegr89@gmail.com>
 */
class PrivateSourcePost
{
    /** @var string */
    private $name;
    /** @var string */
    private $description;
    /** @var SourceAuthor */
    private $author;
    /** @var SourceComment[] */
    private $comments;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return SourceAuthor
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param SourceAuthor $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return SourceComment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param SourceComment[] $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }
}
