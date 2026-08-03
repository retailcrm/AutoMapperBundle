<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldFilter;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Retailcrm\AutoMapperBundle\Mapper\Value\CollectionValue;

class EntityCollectionMappingFilter extends AbstractMappingFilter
{
    /**
     * @param class-string $className
     */
    public function __construct(
        string $className,
        protected EntityManagerInterface $em,
        protected bool $canExistsEntity = false,
        private ?\Closure $classBuilder = null,
        private ?\Closure $filterCallback = null,
    ) {
        parent::__construct($className);
    }

    /**
     * @return array<mixed>|CollectionValue
     */
    public function filter(mixed $value): array|CollectionValue
    {
        if (null === $value) {
            return [];
        }

        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        if (!is_array($value)) {
            return [];
        }

        $removedIds = [];
        foreach ($value as $key => $item) {
            if ($this->isDeleted($item)) {
                $id = $this->resolveDeletedItemId($item);
                if (null !== $id) {
                    $removedIds[] = $id;
                }

                unset($value[$key]);
            }
        }
        unset($item);

        $objectFilter = new EntityMappingFilter(
            $this->className,
            $this->em,
            $this->classBuilder,
            $this->filterCallback
        );
        $objectFilter->setMapper($this->getMapper());

        $values = array_map(static fn ($item) => $objectFilter->filter($item), $value);

        return new CollectionValue($values, $removedIds, $this->canExistsEntity);
    }

    private function isDeleted(mixed $item): bool
    {
        if (is_array($item) && isset($item['deleted'])) {
            return (bool) $item['deleted'];
        }

        return is_object($item)
            && property_exists($item, 'deleted')
            && (bool) $item->deleted;
    }

    private function resolveDeletedItemId(mixed $item): ?int
    {
        if (is_array($item) && isset($item['id'])) {
            return (int) $item['id'];
        }

        if (is_object($item) && property_exists($item, 'id') && $item->id) {
            return (int) $item->id;
        }

        if (null === $this->filterCallback) {
            return null;
        }

        $entity = ($this->filterCallback)($item);
        if (is_object($entity) && method_exists($entity, 'getId') && null !== $entity->getId()) {
            return (int) $entity->getId();
        }

        return null;
    }
}
