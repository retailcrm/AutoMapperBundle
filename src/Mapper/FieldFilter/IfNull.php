<?php

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

/**
 * IfNull applies a default value if the original is null.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class IfNull implements FieldFilterInterface
{
    private $value;

    /**
     * @param mixed $value The value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns a default value if the original is null
     */
    public function filter($value)
    {
        return $value ?: $this->value;
    }
}
