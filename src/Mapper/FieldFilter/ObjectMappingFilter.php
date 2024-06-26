<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

/**
 * Filter object value and apply mapping to given className
 *
 * @author Jorge Garcia Ramos <jorgegr89@gmail.com>
 */
class ObjectMappingFilter extends AbstractMappingFilter
{
    /**
     * Applies the filter to a given value.
     */
    public function filter(mixed $value): ?object
    {
        if (!$value) {
            return null;
        }

        return $this->getMapper()->map($value, $this->className);
    }
}
