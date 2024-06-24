<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

use Doctrine\Common\Collections\Collection;

/**
 * Filter array object value and map inner items to given className
 *
 * @author Jorge Garcia Ramos <jorgegr89@gmail.com>
 */
class ArrayObjectMappingFilter extends AbstractMappingFilter
{
    /**
     * Applies the filter to a given value
     *
     * @return array<?object>
     */
    public function filter(mixed $value): array
    {
        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        if (!is_array($value)) {
            return [];
        }

        $objectFilter = new ObjectMappingFilter($this->className);
        $objectFilter->setMapper($this->getMapper());

        return array_map(function ($item) use ($objectFilter) {
            return $objectFilter->filter($item);
        }, $value);
    }
}
