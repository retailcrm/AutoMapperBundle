<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\Value;

class SimpleValue implements MapperValueInterface
{
    public function __construct(
        protected mixed $value,
        protected bool $exists,
    ) {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getExists(): bool
    {
        return $this->exists;
    }
}
