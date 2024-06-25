<?php

namespace Retailcrm\AutoMapperBundle\Tests\Fixtures;

use Retailcrm\AutoMapperBundle\Mapper\AbstractMap;

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

    public function getDestinationType()
    {
        return 'Retailcrm\AutoMapperBundle\Tests\Fixtures\DestinationPost';
    }

    public function getSourceType()
    {
        return 'Retailcrm\AutoMapperBundle\Tests\Fixtures\SourcePost';
    }
}
