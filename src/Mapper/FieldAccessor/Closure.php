<?php

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

/**
 * Closure access a member value using a closure.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class Closure implements FieldAccessorInterface
{
    /**
     * @var \Closure
     */
    private $closure;

    /**
     * @param $closure The closure
     */
    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    public function getValue($source)
    {
        $closure = $this->closure;

        return $closure($source);
    }
}
