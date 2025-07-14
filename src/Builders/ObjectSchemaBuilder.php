<?php

namespace Strucura\Schema\Builders;

use Illuminate\Support\Traits\Macroable;
use Strucura\Schema\Enums\PropertyTypeEnum;
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

    /**
     * Creates a property of type string
     */
    public function string(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::STRING->value, $isRequired);
    }

    /**
     * Creates a property of type integer
     */
    public function integer(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::INTEGER->value, $isRequired);
    }

    /**
     * Creates a property of type boolean
     */
    public function boolean(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::BOOLEAN->value, $isRequired);
    }

    /**
     * Creates a property of type date
     */
    public function date(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::DATE->value, $isRequired);
    }

    /**
     * Creates a property of type date time
     */
    public function dateTime(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::DATETIME->value, $isRequired);
    }

    /**
     * Creates a property of type float
     */
    public function float(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::FLOAT->value, $isRequired);
    }

    /**
     * Creates a property of type byte
     */
    public function byte(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::BYTE->value, $isRequired);
    }

    /**
     * Creates a property of type binary
     */
    public function binary(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::BINARY->value, $isRequired);
    }

    /**
     * Creates a property of type decimal
     */
    public function decimal(string $name, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::DECIMAL->value, $isRequired);
    }

    /**
     * Creates a property that is an array of items
     *
     * @param  string|PropertyTypeEnum|array<string|PropertyTypeEnum>|\Closure  $items  A single type, an array of types, or a callable for nested schema.
     */
    public function arrayOf(string $name, PropertyTypeEnum|string|array|\Closure $items, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::ARRAY_OF->value, $isRequired, function (Property $property) use ($items) {
            if ($items instanceof \Closure) {
                $nestedDefinition = new self;
                $items($nestedDefinition);
                $property->setAttribute('items', $nestedDefinition->toArray());

                return $this;
            }

            $property->setAttribute('items', [
                'type' => match (true) {
                    is_array($items) => collect($items)->map(function ($item) {
                        return $item instanceof PropertyTypeEnum ? $item->value : $item;
                    })->toArray(),

                    $items instanceof PropertyTypeEnum => [$items->value],

                    default => [$items],
                },
            ]);
        });
    }

    /**
     * Creates a property that is an inline enum
     *
     * @param  array<string|PropertyTypeEnum>  $values
     */
    public function enum(string $name, array $values, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::ENUM->value, $isRequired, function (Property $property) use ($values) {
            $property->setAttribute('enum', $values);
        });
    }

    /**
     * Creates a property that is a nested object
     */
    public function object(string $name, \Closure $callback, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::OBJECT->value, $isRequired, function (Property $property) use ($callback) {
            $nestedDefinition = new self;
            $callback($nestedDefinition);
            $property->setAttribute('properties', $nestedDefinition->toArray()['properties']);
        });
    }

    /**
     * Creates a property that is a reference to another schema
     */
    public function reference(string $name, string $type, bool $isRequired): self
    {
        return $this->addProperty($name, $type, $isRequired);
    }

    /**
     * Creates a property that can be one or more types
     *
     * @param  string  $name  The name of the property.
     * @param  array<string|PropertyTypeEnum>  $types  An array of types, which can be either the string "string" or valid PropertyTypeEnum values.
     * @param  bool  $isRequired  Whether the property is required.
     */
    public function anyOf(string $name, array $types, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::ANY_OF->value, $isRequired, function (Property $property) use ($types) {
            $property->setAttribute('types', $types);
        });
    }

    /**
     * Base property creation functionality
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
     * Converts schema to an array
     *
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
