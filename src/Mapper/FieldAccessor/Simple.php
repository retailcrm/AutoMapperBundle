<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

use Retailcrm\AutoMapperBundle\Mapper\Value\SimpleValue;
use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;

/**
 * Simple returns a value for a member given a property path.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class Simple implements FieldAccessorInterface
{
    private PropertyPath $sourcePropertyPath;

    public function __construct(string|PropertyPath $sourcePropertyPath)
    {
        $this->sourcePropertyPath = new PropertyPath($sourcePropertyPath);
    }

    public function getValue(mixed $source): SimpleValue
    {
        try {
            $exists = true;
            $value = null;
            $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
                ->enableExceptionOnInvalidIndex()
                ->getPropertyAccessor()
            ;

            $value = $propertyAccessor->getValue($source, $this->sourcePropertyPath);
        } catch (NoSuchIndexException|NoSuchPropertyException) {
            $exists = false;
        }

        return new SimpleValue($value, $exists);
    }

    public function getSourcePath(): string
    {
        return str_replace(['[', ']'], '', $this->sourcePropertyPath->__toString());
    }
}
