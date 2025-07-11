<?php

namespace Strucura\Schema;

use BackedEnum;

class Schema
{
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
                $nestedDefinition = new Schema;
                $items($nestedDefinition);
                $property->setAttribute('items', $nestedDefinition->toArray());
            } else {
                $property->setAttribute('items', ['type' => $items]);
            }
        });
    }

    public function addEnum(string $name, string $type, bool $isRequired = false): self
    {
        return $this->addProperty($name, $type, $isRequired);
    }

    public function addBackedEnum(string $name, BackedEnum $enum, bool $isRequired = false): self
    {
        return $this->addProperty($name, 'string', $isRequired, function (Property $property) use ($enum) {
            $values = array_map(fn ($case) => $case->value, $enum::cases());
            $property->setAttribute('enum', $values);
        });
    }

    public function addInlineEnum(string $name, string $type, array $values, bool $isRequired = false): self
    {
        return $this->addProperty($name, $type, $isRequired, function (Property $property) use ($values) {
            $property->setAttribute('enum', $values);
        });
    }

    public function addObject(string $name, \Closure $callback, bool $isRequired = false): self
    {
        return $this->addProperty($name, 'object', $isRequired, function (Property $property) use ($callback) {
            $nestedDefinition = new Schema;
            $callback($nestedDefinition);
            $property->setAttribute('properties', $nestedDefinition->toArray()['properties']);
        });
    }

    public function addProperty(string $name, string $type, bool $isRequired = false, ?\Closure $callback = null): self
    {
        $property = new Property($type, $isRequired);

        if ($callback) {
            $callback($property);
        }

        $this->properties[$name] = $property;

        return $this;
    }

    public function toArray(): array
    {
        $properties = array_map(
            fn ($property) => $property->toArray(),
            $this->properties
        );

        $result = [
            'type' => $this->type,
            'properties' => $properties,
        ];

        return $result;
    }
}
