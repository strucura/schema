<?php

namespace Strucura\Schema\Builders;

use Illuminate\Support\Traits\Macroable;
use Strucura\Schema\Properties\Property;

class ObjectSchemaBuilder
{
    use Macroable;

    /** @var array<string, Property> */
    private array $properties = [];

    private string $type;

    public function __construct(string $type = 'object')
    {
        $this->type = $type;
    }

    public function addString(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, 'string', $isRequired);
    }

    public function addInteger(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, 'integer', $isRequired);
    }

    public function addBoolean(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, 'boolean', $isRequired);
    }

    public function addArray(string $name, string|callable $items, bool $isRequired = false): self
    {
        return $this->addProperty($name, 'array', $isRequired, function (Property $property) use ($items) {
            if (is_callable($items)) {
                $nestedDefinition = new self;
                $items($nestedDefinition);
                $property->setAttribute('items', $nestedDefinition->toArray());
            } else {
                $property->setAttribute('items', ['type' => $items]);
            }
        });
    }

    /**
     * @param string $name
     * @param array<string|int|float> $values
     * @param bool $isRequired
     * @return self
     */
    public function addEnum(string $name, array $values, bool $isRequired = false): self
    {
        return $this->addProperty($name, 'enum', $isRequired, function (Property $property) use ($values) {
            $property->setAttribute('enum', $values);
        });
    }

    public function addObject(string $name, \Closure $callback, bool $isRequired = false): self
    {
        return $this->addProperty($name, 'object', $isRequired, function (Property $property) use ($callback) {
            $nestedDefinition = new self;
            $callback($nestedDefinition);
            $property->setAttribute('properties', $nestedDefinition->toArray()['properties']);
        });
    }

    public function addReference(string $name, string $type, bool $isRequired): self
    {
        return $this->addProperty($name, $type, $isRequired);
    }

    /**
     * @param string $name
     * @param string $type
     * @param bool $isRequired
     * @param \Closure|null $callback
     * @return self
     */
    protected function addProperty(string $name, string $type, bool $isRequired = false, ?\Closure $callback = null): self
    {
        $property = new Property($type, $isRequired);

        if ($callback) {
            $callback($property);
        }

        $this->properties[$name] = $property;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $properties = array_map(
            fn (Property $property) => $property->toArray(),
            $this->properties
        );

        return [
            'type' => $this->type,
            'properties' => $properties,
        ];
    }
}
