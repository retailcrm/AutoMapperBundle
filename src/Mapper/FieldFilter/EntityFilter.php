<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

use Doctrine\ORM\EntityManagerInterface;
use Retailcrm\AutoMapperBundle\Mapper\Exception\InvalidSourceProperty;

class EntityFilter implements FieldFilterInterface
{
    /**
     * @param class-string $className
     */
    public function __construct(
        protected string $className,
        protected EntityManagerInterface $em,
    ) {
    }

    public function filter(mixed $value): mixed
    {
        if (null === $value) {
            return null;
        }

        if (!is_int($value)) {
            throw new InvalidSourceProperty('Entity id must be integer');
        }

        return $this->em->getRepository($this->className)->find($value);
    }
}
