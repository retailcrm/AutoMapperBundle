<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

use Retailcrm\AutoMapperBundle\Mapper\Mapper;

/**
 * Provide easy access to any filter to current mapper object.
 *
 * @author Jorge Garcia Ramos <jorgegr89@gmail.com>
 */
abstract class AbstractMappingFilter implements FieldFilterInterface
{
    private Mapper $mapper;

    /**
     * AbstractMappingFilter constructor.
     *
     * @param class-string $className
     */
    public function __construct(protected string $className)
    {
    }

    protected function getMapper(): Mapper
    {
        return $this->mapper;
    }

    public function setMapper(Mapper $mapper): void
    {
        $this->mapper = $mapper;
    }
}
