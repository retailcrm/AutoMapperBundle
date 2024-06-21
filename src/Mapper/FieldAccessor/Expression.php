<?php

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

use Retailcrm\AutoMapperBundle\Mapper\Exception\InvalidSourceProperty;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\PropertyAccess\PropertyPath;

/**
 * Simple returns a value for a member given a property path.
 *
 * This accessor uses Symfony ExpressionLanguage to extract property value.
 *
 * @author Jorge Garcia Ramos <jorgegr89@gmail.com>
 */
class Expression implements FieldAccessorInterface
{
    /**
     * @var PropertyPath
     */
    private $sourcePropertyPath;

    /**
     * @param string|\Symfony\Component\ExpressionLanguage\Expression $sourcePropertyPath The property path
     */
    public function __construct($sourcePropertyPath)
    {
        $this->sourcePropertyPath = $sourcePropertyPath;
    }

    public function getValue($source)
    {
        $expLanguage = new ExpressionLanguage();
        try {
            return $expLanguage->evaluate(
                'value' . (is_array($source) ? '' : '.') . $this->sourcePropertyPath,
                ['value' => $source]
            );
        } catch (\Exception $ex) {
            if (
                !str_contains($ex->getMessage(), 'Unable to get a property on a non-object')
            ) {
                if (preg_match('/Variable ".*" is not valid/', $ex->getMessage())) {
                    throw new InvalidSourceProperty('Property path "' . $this->sourcePropertyPath . '" is invalid');
                }
                throw $ex;
            }
        }
    }
}
