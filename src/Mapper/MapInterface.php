<?php

namespace Retailcrm\AutoMapperBundle\Mapper;

use Retailcrm\AutoMapperBundle\Mapper\FieldAccessor\FieldAccessorInterface;
use Retailcrm\AutoMapperBundle\Mapper\FieldFilter\FieldFilterInterface;

/**
 * MapInterface defines a map interface.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
interface MapInterface
{
    /**
     * @return FieldAccessorInterface[] An array of field accessors
     */
    public function getFieldAccessors();

    /**
     * @return FieldFilterInterface[] An array of field filters
     */
    public function getFieldFilters();

    /**
     * @return string The source type
     */
    public function getSourceType();

    /**
     * @return string The destination type
     */
    public function getDestinationType();
}
