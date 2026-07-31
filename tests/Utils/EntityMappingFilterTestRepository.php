<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Utils;

use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<EntityMappingFilterTestEntity>
 */
class EntityMappingFilterTestRepository extends EntityRepository
{
    public function findByUuid(string $uuid): ?EntityMappingFilterTestEntity
    {
        return null;
    }
}
