<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

/**
 * IfNull applies a default value if the original is null.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class IfNull implements FieldFilterInterface
{
    public function __construct(private mixed $value)
    {
    }

    /**
     * Returns a default value if the original is null
     */
    public function filter(mixed $value): mixed
    {
        return $value ?: $this->value;
    }
}
