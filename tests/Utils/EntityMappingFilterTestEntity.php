<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Utils;

class EntityMappingFilterTestEntity
{
    public function __construct(
        public ?int $id = null,
        public ?string $uuid = null,
        public ?string $content = null,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
