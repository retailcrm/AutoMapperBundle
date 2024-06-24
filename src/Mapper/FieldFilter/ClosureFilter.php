<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

class ClosureFilter implements FieldFilterInterface
{
    public function __construct(private \Closure $closure)
    {
    }

    public function filter(mixed $value): mixed
    {
        $closure = $this->closure;

        return $closure($value);
    }
}
