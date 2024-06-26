<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Fixtures;

use Retailcrm\AutoMapperBundle\Mapper\Map\AbstractMap;

/**
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class PostMap extends AbstractMap
{
    public function __construct()
    {
        $this->buildDefaultMap();
        $this->route('title', 'name');
    }

    public function getDestinationType(): string
    {
        return 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost';
    }

    public function getSourceType(): string
    {
        return 'Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost';
    }
}
