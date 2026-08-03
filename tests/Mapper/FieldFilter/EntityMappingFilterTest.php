<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Mapper\FieldFilter;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use Retailcrm\AutoMapperBundle\Mapper\FieldFilter\EntityCollectionMappingFilter;
use Retailcrm\AutoMapperBundle\Mapper\FieldFilter\EntityMappingFilter;
use Retailcrm\AutoMapperBundle\Mapper\Mapper;
use Retailcrm\AutoMapperBundle\Mapper\Value\CollectionValue;
use Retailcrm\AutoMapperBundle\Tests\Utils\EntityMappingFilterTestEntity;
use Retailcrm\AutoMapperBundle\Tests\Utils\EntityMappingFilterTestRepository;

class EntityMappingFilterTest extends TestCase
{
    public function testFilterCanResolveExistingEntityById(): void
    {
        $entity = new EntityMappingFilterTestEntity(7, 'existing-uuid', 'old content');
        $repository = $this->createRepositoryResolvedById($entity, 7);
        $filter = new EntityMappingFilter(
            EntityMappingFilterTestEntity::class,
            $this->createEntityManager($repository)
        );

        $mapper = new Mapper();
        $mapper->createMap('array', EntityMappingFilterTestEntity::class);
        $filter->setMapper($mapper);

        $result = $filter->filter(['id' => 7, 'content' => 'new content']);

        $this->assertSame($entity, $result);
        $this->assertSame('new content', $entity->content);
    }

    public function testFilterCallbackCanResolveExistingEntity(): void
    {
        $entity = new EntityMappingFilterTestEntity(1, 'existing-uuid', 'old content');
        $repository = $this->createRepositoryResolvedByUuid($entity, 'existing-uuid');
        $em = $this->createEntityManager($repository);

        $filter = new EntityMappingFilter(
            EntityMappingFilterTestEntity::class,
            $em,
            filterCallback: static function (mixed $value) use ($em): ?object {
                $repository = $em->getRepository(EntityMappingFilterTestEntity::class);
                \assert($repository instanceof EntityMappingFilterTestRepository);

                return $repository->findByUuid($value['uuid']);
            }
        );

        $mapper = new Mapper();
        $mapper->createMap('array', EntityMappingFilterTestEntity::class);
        $filter->setMapper($mapper);

        $result = $filter->filter(['uuid' => 'existing-uuid', 'content' => 'new content']);

        $this->assertSame($entity, $result);
        $this->assertSame('new content', $entity->content);
    }

    public function testCollectionFilterCallbackCanResolveDeletedItemId(): void
    {
        $entity = new EntityMappingFilterTestEntity(15, 'deleted-uuid', 'deleted content');
        $repository = $this->createRepositoryResolvedByUuid($entity, 'deleted-uuid');
        $em = $this->createEntityManager($repository);
        $filter = new EntityCollectionMappingFilter(
            EntityMappingFilterTestEntity::class,
            $em,
            filterCallback: static function (mixed $value) use ($em): ?object {
                $repository = $em->getRepository(EntityMappingFilterTestEntity::class);
                \assert($repository instanceof EntityMappingFilterTestRepository);

                return $repository->findByUuid($value['uuid']);
            }
        );

        $mapper = new Mapper();
        $mapper->createMap('array', EntityMappingFilterTestEntity::class);
        $filter->setMapper($mapper);

        $result = $filter->filter([
            ['uuid' => 'deleted-uuid', 'deleted' => true],
        ]);

        $this->assertInstanceOf(CollectionValue::class, $result);
        $this->assertSame([15], $result->getDeletedItems());
        $this->assertSame([], $result->getValue());
    }

    /**
     * @param EntityRepository<EntityMappingFilterTestEntity> $repository
     */
    private function createEntityManager(EntityRepository $repository): EntityManagerInterface
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $em
            ->method('getRepository')
            ->willReturn($repository)
        ;

        return $em;
    }

    private function createRepositoryResolvedById(
        EntityMappingFilterTestEntity $entity,
        int $id,
    ): EntityMappingFilterTestRepository {
        $repository = $this
            ->getMockBuilder(EntityMappingFilterTestRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['find', 'findByUuid'])
            ->getMock()
        ;
        $repository
            ->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($entity)
        ;
        $repository
            ->expects($this->never())
            ->method('findByUuid')
        ;

        return $repository;
    }

    private function createRepositoryResolvedByUuid(
        EntityMappingFilterTestEntity $entity,
        string $uuid,
    ): EntityMappingFilterTestRepository {
        $repository = $this
            ->getMockBuilder(EntityMappingFilterTestRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['find', 'findByUuid'])
            ->getMock()
        ;
        $repository
            ->expects($this->never())
            ->method('find')
        ;
        $repository
            ->expects($this->once())
            ->method('findByUuid')
            ->with($uuid)
            ->willReturn($entity)
        ;

        return $repository;
    }
}
