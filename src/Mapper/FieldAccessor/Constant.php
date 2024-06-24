<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

/**
 * Constant returns a constant as a value for a member.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class Constant implements FieldAccessorInterface
{
    public function __construct(
        private mixed $value
    ) {
        $this->value = $value;
    }

    public function getValue(mixed $source): mixed
    {
        return $this->value;
    }
}
