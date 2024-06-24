<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\Exception;

class InvalidClassConstructorException extends \Exception
{
    public function __construct(string $className, ?\Exception $previous = null)
    {
        parent::__construct(
            sprintf('Constructor for class "%s" is invalid. Should not have required arguments.', $className),
            0,
            $previous
        );
    }
}
