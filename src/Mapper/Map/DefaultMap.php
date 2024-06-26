<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Mapper\Map;

use Retailcrm\AutoMapperBundle\Mapper\FieldAccessor\Simple;

/**
 * DefaultMap is an auto generated map.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class DefaultMap extends AbstractMap
{
    /**
     * Creates a default map given the source and destination types.
     *
     * @param class-string $destinationType
     */
    public function __construct(
        private string $sourceType,
        private string $destinationType
    ) {
        $this->buildDefaultMap();
    }

    /**
     * Associate a member to another member given their property pathes.
     */
    public function route(string $destinationMember, string $sourceMember): self
    {
        $this->fieldAccessors[$destinationMember] = new Simple($this->getCorrectPropertyPath($sourceMember));

        return $this;
    }

    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    public function getDestinationType(): string
    {
        return $this->destinationType;
    }

    public function buildDefaultMap(): self
    {
        $reflectionClass = new \ReflectionClass($this->getDestinationType());

        foreach ($reflectionClass->getProperties() as $property) {
            $this->fieldAccessors[$property->name] = new Simple($this->getCorrectPropertyPath($property->name));
        }

        return $this;
    }

    private function getCorrectPropertyPath(string $name): string
    {
        return 'array' == $this->sourceType ? '[' . $name . ']' : $name;
    }
}
