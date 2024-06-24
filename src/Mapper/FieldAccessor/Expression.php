<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

use Retailcrm\AutoMapperBundle\Mapper\Exception\InvalidSourceProperty;
use Symfony\Component\ExpressionLanguage\Expression as SymfonyExpression;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Simple returns a value for a member given a property path.
 *
 * This accessor uses Symfony ExpressionLanguage to extract property value.
 *
 * @author Jorge Garcia Ramos <jorgegr89@gmail.com>
 */
class Expression implements FieldAccessorInterface
{
    private SymfonyExpression $sourcePropertyPath;

    public function __construct(string|SymfonyExpression $sourcePropertyPath)
    {
        if ($sourcePropertyPath instanceof SymfonyExpression) {
            $this->sourcePropertyPath = $sourcePropertyPath;

            return;
        }

        $this->sourcePropertyPath = new SymfonyExpression($sourcePropertyPath);
    }

    public function getValue(mixed $source): mixed
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

        return null;
    }
}
