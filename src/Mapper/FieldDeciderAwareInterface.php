<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper;

interface FieldDeciderAwareInterface
{
    public function setFieldDecider(?FieldDeciderInterface $fieldDecider): void;
}
