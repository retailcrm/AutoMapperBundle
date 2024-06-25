<?php

namespace Retailcrm\AutoMapperBundle\Tests\Fixtures;

/**
 * @author Brian Feaver <brian.feaver@gmail.com>
 */
class PrivateDestinationPost
{
    private $id;
    private $title;
    private $description;
    private $author;

    public function getId()
    {
        return $this->id;
    }

    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
