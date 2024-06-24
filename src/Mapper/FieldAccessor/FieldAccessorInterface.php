<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

/**
 * FieldAccessorInterface defines how the value of a member is resolved.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
interface FieldAccessorInterface
{
    /**
     * Gets the value for the member given the source object.
     */
    public function getValue(mixed $source): mixed;
}
