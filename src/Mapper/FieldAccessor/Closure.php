<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\FieldAccessor;

use Retailcrm\AutoMapperBundle\Mapper\Exception\SkipFieldMappingException;
use Retailcrm\AutoMapperBundle\Mapper\FieldDeciderAwareInterface;
use Retailcrm\AutoMapperBundle\Mapper\FieldDeciderInterface;

/**
 * ClosureFilter access a member value using a closure.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class Closure implements FieldAccessorInterface, FieldDeciderAwareInterface
{
    private ?FieldDeciderInterface $fieldDecider = null;
    private ?string $destinationMember = null;
    private ?string $routedSourceField = null;
    private bool $effectiveSkipNonExists = false;

    public function __construct(
        private \Closure $closure,
        private ?string $sourceField = null,
        private ?bool $skipNonExists = null,
    ) {
    }

    public function getValue(mixed $source): mixed
    {
        $closure = $this->closure;
        $fieldDecider = $this->fieldDecider;

        if ($this->shouldSkipNonExistingField($source)) {
            throw new SkipFieldMappingException();
        }

        return $fieldDecider ? $closure($source, $fieldDecider) : $closure($source);
    }

    public function setFieldDecider(?FieldDeciderInterface $fieldDecider): void
    {
        $this->fieldDecider = $fieldDecider;
    }

    public function setDestinationMember(string $destinationMember): void
    {
        $this->destinationMember = $destinationMember;
    }

    public function setRoutedSourceField(?string $routedSourceField): void
    {
        $this->routedSourceField = $routedSourceField;
    }

    public function setEffectiveSkipNonExists(bool $skipNonExists): void
    {
        $this->effectiveSkipNonExists = $skipNonExists;
    }

    public function getSkipNonExistsOverride(): ?bool
    {
        return $this->skipNonExists;
    }

    private function shouldSkipNonExistingField(mixed $source): bool
    {
        if (!$this->effectiveSkipNonExists || !is_object($source) || null === $this->fieldDecider) {
            return false;
        }

        $sourceField = $this->sourceField ?? $this->routedSourceField ?? $this->destinationMember;
        if (null === $sourceField) {
            return false;
        }

        return !$this->fieldDecider->shouldMapField($source, $sourceField);
    }
}
