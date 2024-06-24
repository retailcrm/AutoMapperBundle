<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\Map;

use Retailcrm\AutoMapperBundle\Mapper\AfterMapper\AfterMapperInterface;
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
    public function getFieldAccessors(): array;

    /**
     * @return FieldFilterInterface[] An array of field filters
     */
    public function getFieldFilters(): array;

    /**
     * The source type
     */
    public function getSourceType(): string;

    /**
     * The destination type
     *
     * @return class-string
     */
    public function getDestinationType(): string;

    /** @return array<string,string> */
    public function getFieldRoutes(): array;

    public function getSkipNull(): bool;

    public function getSkipNonExists(): bool;

    public function getOverwriteIfSet(): bool;

    /** @return AfterMapperInterface[] */
    public function getAfterMappers(): array;
}
