<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper;

interface FieldDeciderInterface
{
    public function shouldMapField(object $source, string $field): bool;
}
