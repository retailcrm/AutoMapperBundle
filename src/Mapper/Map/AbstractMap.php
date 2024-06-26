<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\Map;

use Retailcrm\AutoMapperBundle\Mapper\AfterMapper\AfterMapperInterface;
use Retailcrm\AutoMapperBundle\Mapper\FieldAccessor\FieldAccessorInterface;
use Retailcrm\AutoMapperBundle\Mapper\FieldAccessor\Simple;
use Retailcrm\AutoMapperBundle\Mapper\FieldFilter\FieldFilterInterface;

/**
 * AbstractMap returns a value for a member given a property path
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
abstract class AbstractMap implements MapInterface
{
    /** @var FieldAccessorInterface[] */
    protected array $fieldAccessors = [];
    /** @var FieldFilterInterface[] */
    protected array $fieldFilters = [];
    /** @var array<string,string> */
    protected array $fieldRoutes = [];
    protected bool $overwriteIfSet = true;
    protected bool $skipNull = false;
    protected bool $skipNonExists = false;
    /** @var AfterMapperInterface[] */
    protected array $afterMappers = [];

    public function buildDefaultMap(): self
    {
        $reflectionClass = new \ReflectionClass($this->getDestinationType());

        foreach ($reflectionClass->getProperties() as $property) {
            $this->fieldAccessors[$property->name] = new Simple(
                $this->getCorrectPropertyPath($property->name)
            );
        }

        return $this;
    }

    /**
     * Associate a member to another member given their property pathes.
     */
    public function route(string $destinationMember, string $sourceMember): self
    {
        $this->fieldAccessors[$destinationMember] = new Simple(
            $this->getCorrectPropertyPath($sourceMember)
        );
        $this->fieldRoutes[$destinationMember] = $sourceMember;

        return $this;
    }

    /**
     * Applies a field accessor policy to a member.
     */
    public function forMember(string $destinationMember, FieldAccessorInterface $fieldMapper): self
    {
        $this->fieldAccessors[$destinationMember] = $fieldMapper;

        return $this;
    }

    /**
     * Applies a filter to the field.
     */
    public function filter(string $destinationMember, FieldFilterInterface $fieldFilter): self
    {
        $this->fieldFilters[$destinationMember] = $fieldFilter;

        return $this;
    }

    /**
     * Sets whether to skip the source value if it is null.
     */
    public function setSkipNull(bool $value): self
    {
        $this->skipNull = $value;

        return $this;
    }

    public function getSkipNull(): bool
    {
        return $this->skipNull;
    }

    public function setSkipNonExists(bool $value): self
    {
        $this->skipNonExists = $value;

        return $this;
    }

    public function getSkipNonExists(): bool
    {
        return $this->skipNonExists;
    }

    /**
     * Sets whether to overwrite the destination value if it is already set.
     */
    public function setOverwriteIfSet(bool $value): self
    {
        $this->overwriteIfSet = $value;

        return $this;
    }

    public function getOverwriteIfSet(): bool
    {
        return $this->overwriteIfSet;
    }

    /**
     * Ignore the destination field.
     */
    public function ignoreMember(string $destinationMember): self
    {
        unset($this->fieldAccessors[$destinationMember]);

        return $this;
    }

    public function getFieldAccessors(): array
    {
        return $this->fieldAccessors;
    }

    public function getFieldFilters(): array
    {
        return $this->fieldFilters;
    }

    public function addAfterMapper(AfterMapperInterface $afterMapper): self
    {
        $this->afterMappers[] = $afterMapper;

        return $this;
    }

    /** @return AfterMapperInterface[] */
    public function getAfterMappers(): array
    {
        return $this->afterMappers;
    }

    /** @return array<string,string> */
    public function getFieldRoutes(): array
    {
        return $this->fieldRoutes;
    }

    private function getCorrectPropertyPath(string $name): string
    {
        return 'array' === $this->getSourceType() ? '[' . $name . ']' : $name;
    }
}
