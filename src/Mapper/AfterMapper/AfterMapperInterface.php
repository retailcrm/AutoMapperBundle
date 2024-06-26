<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\AfterMapper;

interface AfterMapperInterface
{
    public function afterMapping(mixed $source, string|object $destination): mixed;
}
