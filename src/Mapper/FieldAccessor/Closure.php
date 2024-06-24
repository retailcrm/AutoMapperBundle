<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

/**
 * ClosureFilter access a member value using a closure.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class Closure implements FieldAccessorInterface
{
    public function __construct(private \Closure $closure)
    {
        $this->closure = $closure;
    }

    public function getValue(mixed $source): mixed
    {
        $closure = $this->closure;

        return $closure($source);
    }
}
