<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Mapper;

use PHPUnit\Framework\TestCase;
use Retailcrm\AutoMapperBundle\Mapper\Exception\InvalidClassConstructorException;
use Retailcrm\AutoMapperBundle\Mapper\FieldAccessor\Closure;
use Retailcrm\AutoMapperBundle\Mapper\FieldAccessor\Expression;
use Retailcrm\AutoMapperBundle\Mapper\FieldFilter\ArrayObjectMappingFilter;
use Retailcrm\AutoMapperBundle\Mapper\FieldFilter\IfNull;
use Retailcrm\AutoMapperBundle\Mapper\FieldFilter\ObjectMappingFilter;
use Retailcrm\AutoMapperBundle\Mapper\Mapper;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationAuthor;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationComment;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\PostMap;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\PrivateDestinationPost;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\PrivateSourcePost;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\SourceAuthor;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\SourceComment;
use Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost;

/**
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class MapperTest extends TestCase
{
    public function testDefaultMap(): void
    {
        // ARRANGE
        $source = new SourcePost();
        $source->description = 'Symfony2 developer';
        $destination = new DestinationPost();
        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost');

        // ACT
        $mapper->map($source, $destination);

        // ASSERT
        $this->assertEquals('Symfony2 developer', $destination->description);
    }

    public function testCustomMap(): void
    {
        // ARRANGE
        $source = new SourcePost();
        $source->name = 'Michel';
        $source->description = 'Symfony2 developer';
        $destination = new DestinationPost();
        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->route('title', 'name')
        ;

        // ACT
        $mapper->map($source, $destination);

        // ASSERT
        $this->assertEquals('Michel', $destination->title);
        $this->assertEquals('Symfony2 developer', $destination->description);
    }

    public function testInDepthMap(): void
    {
        // ARRANGE
        $source = new SourcePost();
        $source->author = new SourceAuthor();
        $source->author->name = 'Michel';
        $destination = new DestinationPost();
        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->route('author', 'author.name')
        ;

        // ACT
        $mapper->map($source, $destination);

        // ASSERT
        $this->assertEquals('Michel', $destination->author);
    }

    public function testClosuredMap(): void
    {
        // ARRANGE
        $source = new SourcePost();
        $source->author = new SourceAuthor();
        $source->author->name = 'Michel';
        $destination = new DestinationPost();
        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->forMember('author', new Closure(function (SourcePost $s) {
                return $s->author->name;
            }))
        ;

        // ACT
        $mapper->map($source, $destination);

        // ASSERT
        $this->assertEquals('Michel', $destination->author);
    }

    public function testMapRegistring(): void
    {
        // ARRANGE
        $source = new SourcePost();
        $source->name = 'Michel';
        $source->description = 'Symfony2 developer';
        $destination = new DestinationPost();
        $mapper = new Mapper();
        $mapper->registerMap(new PostMap());

        // ACT
        $mapper->map($source, $destination);

        // ASSERT
        $this->assertEquals('Michel', $destination->title);
        $this->assertEquals('Symfony2 developer', $destination->description);
    }

    public function testMappingPolicy(): void
    {
        // ARRANGE
        $source = new SourcePost();
        $source->name = 'Michel';
        $destination = new DestinationPost();
        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->filter('title', new IfNull(''))
        ;

        // ACT
        $mapper->map($source, $destination);

        // ASSERT
        $this->assertEquals('', $destination->title);
    }

    public function testMappingArray(): void
    {
        // ARRANGE
        $source = ['title' => 'Michel'];
        $destination = new DestinationPost();
        $mapper = new Mapper();
        $mapper->createMap('array', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost');

        // ACT
        $mapper->map($source, $destination);

        // ASSERT
        $this->assertEquals('Michel', $destination->title);
    }

    public function testIgnoreField(): void
    {
        // ARRANGE
        $source = new SourcePost();
        $source->description = 'Symfony2 developer';
        $destination = new PrivateDestinationPost();
        $mapper = new Mapper();
        $mapper
            ->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\PrivateDestinationPost')
            ->setSkipNonExists(true)
            ->ignoreMember('id')
        ;

        // ACT
        try {
            $mapper->map($source, $destination);
        } catch (\Exception $e) {
            $this->fail('should not catch an exception - ' . $e->getMessage());
        }

        // ASSERT
        $this->assertNull($destination->getId());
    }

    public function testOverwrittenIfSet(): void
    {
        $source = new SourcePost();
        $source->description = 'Symfony2 developer';
        $destination = new DestinationPost();
        $destination->description = 'Foo bar';
        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost');

        try {
            $mapper->map($source, $destination);
        } catch (\Exception $e) {
            $this->fail('should not catch an exception - ' . $e->getMessage());
        }

        $this->assertEquals('Symfony2 developer', $destination->description);
    }

    public function testNotOverwrittenIfSet(): void
    {
        $source = new SourcePost();
        $source->description = 'Symfony2 developer';
        $destination = new DestinationPost();
        $destination->description = 'Foo bar';
        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->setOverwriteIfSet(false)
        ;

        try {
            $mapper->map($source, $destination);
        } catch (\Exception $e) {
            $this->fail('should not catch an exception - ' . $e->getMessage());
        }

        $this->assertEquals('Foo bar', $destination->description);
    }

    public function testSkipNull(): void
    {
        $source = new SourcePost();
        $source->description = null;
        $destination = new DestinationPost();
        $destination->description = 'Foo bar';
        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->setSkipNull(true)
        ;

        try {
            $mapper->map($source, $destination);
        } catch (\Exception $e) {
            $this->fail('should not catch an exception - ' . $e->getMessage());
        }

        $this->assertEquals('Foo bar', $destination->description);
    }

    public function testMappingDeepObject(): void
    {
        $source = new SourcePost();
        $source->description = 'Symfony2 developer';
        $source->author = new SourceAuthor();
        $source->author->name = 'Thomas';

        $destination = new DestinationPost();
        $destination->description = 'Symfony2 developer';
        $destination->author = new DestinationAuthor();
        $destination->author->name = 'Thomas';

        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->route('author', 'author')
            ->filter('author', new ObjectMappingFilter('Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationAuthor'))
        ;
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourceAuthor', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationAuthor');

        $mapper->map($source, $result = new DestinationPost());

        $this->assertEquals($destination, $result);
    }

    public function testMappingDeepArrayToObject(): void
    {
        $source = new SourcePost();
        $source->description = 'Symfony2 developer';
        $source->author = ['name' => 'Thomas'];

        $destination = new DestinationPost();
        $destination->description = 'Symfony2 developer';
        $destination->author = new DestinationAuthor();
        $destination->author->name = 'Thomas';

        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->route('author', 'author')
            ->filter('author', new ObjectMappingFilter('Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationAuthor'))
        ;
        $mapper->createMap('array', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationAuthor');

        $mapper->map($source, $result = new DestinationPost());

        $this->assertEquals($destination, $result);
    }

    public function testMappingDeepArrayObject(): void
    {
        $sourceComment1 = new SourceComment();
        $sourceComment1->content = 'content1';

        $sourceComment2 = new SourceComment();
        $sourceComment2->content = 'content2';

        $source = new SourcePost();
        $source->description = 'Symfony2 developer';
        $source->comments = [$sourceComment1, $sourceComment2];

        $destinationComment1 = new DestinationComment();
        $destinationComment1->content = 'content1';

        $destinationComment2 = new DestinationComment();
        $destinationComment2->content = 'content2';

        $destination = new DestinationPost();
        $destination->description = 'Symfony2 developer';
        $destination->comments = [$destinationComment1, $destinationComment2];

        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->route('comments', 'comments')
            ->filter('comments', new ArrayObjectMappingFilter('Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationComment'))
        ;
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourceComment', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationComment');

        $mapper->map($source, $result = new DestinationPost());

        $this->assertEquals($destination, $result);
    }

    public function testMapExpression(): void
    {
        $sourceComment1 = new SourceComment();
        $sourceComment1->content = 'content1';

        $sourceComment2 = new SourceComment();
        $sourceComment2->content = 'content2';

        $source = new PrivateSourcePost();
        $source->setDescription('Symfony2 developer');
        $source->setComments([$sourceComment1, $sourceComment2]);

        $destinationComment1 = new DestinationComment();
        $destinationComment1->content = 'content1';

        $destinationComment2 = new DestinationComment();
        $destinationComment2->content = 'content2';

        $destination = new DestinationPost();
        $destination->description = 'Symfony2 developer';
        $destination->comments = [$destinationComment1, $destinationComment2];

        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\PrivateSourcePost', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost')
            ->forMember('comments', new Expression('getComments()'))
            ->filter('comments', new ArrayObjectMappingFilter('Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationComment'))
        ;
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourceComment', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationComment');

        $mapper->map($source, $result = new DestinationPost());

        $this->assertEquals($destination, $result);
    }

    public function testMapToClassName(): void
    {
        $source = new SourceAuthor();
        $source->name = 'Thomas';

        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourceAuthor', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationAuthor');
        $result = $mapper->map($source, 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationAuthor');

        $this->assertInstanceOf('Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationAuthor', $result);
        $this->assertEquals('Thomas', $result->name);
    }

    public function testMapInvalidConstructor(): void
    {
        $this->expectException(InvalidClassConstructorException::class);
        $source = new SourceAuthor();

        $mapper = new Mapper();
        $mapper->createMap('Retailcrm\AutoMapperBundle\Tests\Fixtures\SourceAuthor', 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationComplexAuthor');
        $mapper->map($source, 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationComplexAuthor');
    }
}
