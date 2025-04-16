<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

use Doctrine\ORM\EntityManagerInterface;

class EntityMappingFilter extends AbstractMappingFilter
{
    /**
     * @param class-string $className
     */
    public function __construct(
        string $className,
        protected EntityManagerInterface $em,
        private ?\Closure $classBuilder = null,
    ) {
        parent::__construct($className);
    }

    public function filter(mixed $value): ?object
    {
        if (!$value) {
            return null;
        }

        $entity = null;
        if (isset($value['id'])) {
            $entity = $this->em->getRepository($this->className)->find($value['id']);
        }

        if (!$entity && null !== $this->classBuilder) {
            $entity = $this->classBuilder->call($this, $value);
        }

        return $this->getMapper()->map($value, $entity ?: $this->className);
    }
}
