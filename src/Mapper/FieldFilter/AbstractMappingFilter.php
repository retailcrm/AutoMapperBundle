<?php

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

use Retailcrm\AutoMapperBundle\Mapper\Mapper;

/**
 * Provide easy access to any filter to current mapper object.
 *
 * @author Jorge Garcia Ramos <jorgegr89@gmail.com>
 */
abstract class AbstractMappingFilter implements FieldFilterInterface
{
    /** @var Mapper */
    private $mapper;
    /** @var string */
    protected $className;

    /**
     * AbstractMappingFilter constructor.
     *
     * @param string $className
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * @return Mapper
     */
    protected function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param Mapper $mapper
     */
    public function setMapper($mapper): void
    {
        $this->mapper = $mapper;
    }
}
