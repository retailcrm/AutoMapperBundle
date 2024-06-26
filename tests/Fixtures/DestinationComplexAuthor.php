<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Fixtures;

class DestinationComplexAuthor
{
    /**
     * DestinationComplexAuthor constructor.
     */
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
