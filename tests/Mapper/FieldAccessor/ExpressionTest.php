<?php

namespace Retailcrm\AutoMapperBundle\Tests\Mapper\FieldAccessor;

use PHPUnit\Framework\TestCase;
use Retailcrm\AutoMapperBundle\Mapper\Exception\InvalidSourceProperty;
use Retailcrm\AutoMapperBundle\Mapper\FieldAccessor\Expression;

class ExpressionTest extends TestCase
{
    public function testAccessObject(): void
    {
        $accessor = new Expression('field');

        $origin = new \stdClass();
        $origin->field = 'value';

        $this->assertEquals('value', $accessor->getValue($origin));
    }

    public function testAccessArray(): void
    {
        $accessor = new Expression('["friends"][0]["details"].name');

        $details = new \stdClass();
        $details->name = 'Josh';

        $user = [
            'friends' => [
                [
                    'details' => $details,
                ],
            ],
        ];

        $this->assertEquals('Josh', $accessor->getValue($user));
    }

    public function testAccessFail(): void
    {
        $this->expectException(InvalidSourceProperty::class);
        $accessor = new Expression('friends.details.name');

        $user = [
            'friends' => [
                [
                    'details' => [
                        'name' => 'Josh',
                    ],
                ],
            ],
        ];

        $accessor->getValue($user);
    }

    public function testAccessString(): void
    {
        $this->expectException(\RuntimeException::class);
        $accessor = new Expression('credentials.username');

        $user = 'user';

        $this->assertNull($accessor->getValue($user));
    }
}
