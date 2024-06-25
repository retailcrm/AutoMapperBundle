<?php

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

/**
 * Constant returns a constant as a value for a member.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class Constant implements FieldAccessorInterface
{
    private $value;

    /**
     * @param $value The constant
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue($source)
    {
        return $this->value;
    }
}
