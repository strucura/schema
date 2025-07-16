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

    public function __construct(private string $type = 'object') {}

    /**
     * Creates a property of type string
     */
    public function string(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'string', $isRequired);
    }

    /**
     * Creates a property of type integer
     */
    public function integer(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'integer', $isRequired);
    }

    /**
     * Creates a property of type boolean
     */
    public function boolean(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'boolean', $isRequired);
    }

    /**
     * Creates a property of type date
     */
    public function date(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'date', $isRequired);
    }

    /**
     * Creates a property of type date time
     */
    public function dateTime(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'datetime', $isRequired);
    }

    /**
     * Creates a property of type float
     */
    public function float(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'float', $isRequired);
    }

    /**
     * Creates a property of type byte
     */
    public function byte(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'byte', $isRequired);
    }

    /**
     * Creates a property of type binary
     */
    public function binary(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'binary', $isRequired);
    }

    /**
     * Creates a property of type decimal
     */
    public function decimal(string $name, bool $isRequired = false): self
    {
        return $this->primitive($name, 'decimal', $isRequired);
    }

    /**
     * Standardized means of creating primitive types
     */
    protected function primitive(string $name, string $primitiveType, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::PRIMITIVE, $isRequired, function (Property $property) use ($primitiveType) {
            $property->setAttribute('subtype', $primitiveType);
        });
    }

    /**
     * Creates a property that is an array of items
     */
    public function arrayOf(string $name, \Closure $callback, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::ARRAY_OF, $isRequired, function (Property $property) use ($callback) {
            $mixedPropertyBuilder = new MixedPropertyBuilder;
            $callback($mixedPropertyBuilder);

            $property->setAttribute('subtype', $mixedPropertyBuilder->toArray());
        });
    }

    /**
     * Creates a property that is an inline enum
     *
     * @param  array<string|PropertyTypeEnum>  $values
     */
    public function enum(string $name, array $values, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::ENUM, $isRequired, function (Property $property) use ($values) {
            $property->setAttribute('subtype', $values);
        });
    }

    /**
     * Creates a property that is a nested object
     */
    public function object(string $name, \Closure $callback, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::OBJECT, $isRequired, function (Property $property) use ($callback) {
            $nestedDefinition = new self;
            $callback($nestedDefinition);
            $property->setAttribute('subtype', $nestedDefinition->toArray()['properties']);
        });
    }

    /**
     * Creates a property that is a reference to another schema
     */
    public function reference(string $name, string $type, bool $isRequired): self
    {
        return $this->addProperty($name, PropertyTypeEnum::REFERENCE, $isRequired, function (Property $property) use ($type) {
            $property->setAttribute('subtype', $type);
        });
    }

    /**
     * Creates a property that can be one or more types
     *
     * @param  string  $name  The name of the property.
     * @param  bool  $isRequired  Whether the property is required.
     */
    public function anyOf(string $name, \Closure $closure, bool $isRequired = false): self
    {
        return $this->addProperty($name, PropertyTypeEnum::ANY_OF, $isRequired, function (Property $property) use ($closure) {
            $builder = new MixedPropertyBuilder;

            $closure($builder);

            $property->setAttribute('subtype', $builder->toArray());
        });
    }

    /**
     * Base property creation functionality
     */
    protected function addProperty(string $name, PropertyTypeEnum $type, bool $isRequired = false, ?\Closure $callback = null): self
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
