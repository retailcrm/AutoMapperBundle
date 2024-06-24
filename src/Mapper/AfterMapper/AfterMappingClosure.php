<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\AfterMapper;

class AfterMappingClosure implements AfterMapperInterface
{
    public function __construct(private \Closure $closure)
    {
    }

    public function afterMapping(mixed $source, mixed $destination): mixed
    {
        $closure = $this->closure;

        return $closure($source, $destination);
    }
}
