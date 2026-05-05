<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

use Retailcrm\AutoMapperBundle\Mapper\FieldDeciderAwareInterface;
use Retailcrm\AutoMapperBundle\Mapper\FieldDeciderInterface;

/**
 * ClosureFilter access a member value using a closure.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class Closure implements FieldAccessorInterface, FieldDeciderAwareInterface
{
    private ?FieldDeciderInterface $fieldDecider;

    public function __construct(private \Closure $closure)
    {
        $this->closure = $closure;
    }

    public function getValue(mixed $source): mixed
    {
        $closure = $this->closure;
        $fieldDecider = $this->fieldDecider;

        return $fieldDecider ? $closure($source, $fieldDecider) : $closure($source);
    }

    public function setFieldDecider(?FieldDeciderInterface $fieldDecider): void
    {
        $this->fieldDecider = $fieldDecider;
    }
}
