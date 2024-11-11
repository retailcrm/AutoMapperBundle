<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

use Doctrine\ORM\EntityManagerInterface;
use Retailcrm\AutoMapperBundle\Mapper\Exception\InvalidSourceProperty;
use Retailcrm\AutoMapperBundle\Mapper\Mapper;

class Relationship implements FieldAccessorInterface
{
    /**
     * @param class-string $parentClass
     * @param class-string $class
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Mapper $mapper,
        private string $parentClass,
        private string $class,
        private string $field,
    ) {
    }

    public function getValue(mixed $source): mixed
    {
        if (null === $source[$this->field]) {
            return null;
        }

        if (empty($source['id'])) {
            return $this->mapper->map($source[$this->field], $this->class);
        }

        $parent = $this->entityManager->getRepository($this->parentClass)->find($source['id']);

        if (!$parent) {
            throw new InvalidSourceProperty('Parent not exists');
        }

        $accessor = 'get' . ucfirst($this->field);

        return $this->mapper->map($source[$this->field], $parent->$accessor());
    }
}
