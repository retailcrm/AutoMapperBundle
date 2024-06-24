<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

/**
 * FieldFilterInterface applies a filter to a value after its resolution.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
interface FieldFilterInterface
{
    /**
     * Applies the filter to a given value.
     */
    public function filter(mixed $value): mixed;
}
