<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Mapper\FieldAccessor;

use PHPUnit\Framework\TestCase;
use Retailcrm\AutoMapperBundle\Mapper\FieldAccessor\Simple;

class SimpleTest extends TestCase
{
    public function testAccessObject(): void
    {
        $accessor = new Simple('field');

        $origin = new \stdClass();
        $origin->field = 'value';

        $value = $accessor->getValue($origin);
        $this->assertTrue($value->getExists());
        $this->assertEquals('value', $value->getValue());
    }

    public function testAccessArrayProperty(): void
    {
        $accessor = new Simple('field[0]');

        $origin = new \stdClass();
        $origin->field = ['value'];

        $value = $accessor->getValue($origin);
        $this->assertTrue($value->getExists());
        $this->assertEquals('value', $value->getValue());
    }

    public function testNoSuchPropertyException(): void
    {
        $accessor = new Simple('field_test');

        $origin = new \stdClass();
        $origin->field = 'value';

        $value = $accessor->getValue($origin);
        $this->assertFalse($value->getExists());
        $this->assertNull($value->getValue());
    }

    public function testNoSuchIndexException(): void
    {
        $accessor = new Simple('field[1]');

        $origin = new \stdClass();
        $origin->field = ['value'];

        $value = $accessor->getValue($origin);
        $this->assertFalse($value->getExists());
        $this->assertNull($value->getValue());
    }
}
