<?php

namespace Strucura\Schema\Builders;

use Strucura\Schema\Enums\PropertyTypeEnum;

class MixedPropertyBuilder
{
    /**
     * @var array<array{type: string, subtype: mixed}>
     */
    protected array $items = [];

    /**
     * Adds a primitive type to the array.
     *
     * @param  string  $type  The primitive type (e.g., 'string', 'integer').
     */
    public function addPrimitive(string $type): self
    {
        $this->items[] = [
            'type' => PropertyTypeEnum::PRIMITIVE->value,
            'subtype' => $type,
        ];

        return $this;
    }

    /**
     * Adds a string type to the array.
     */
    public function string(): self
    {
        return $this->addPrimitive('string');
    }

    /**
     * Adds an integer type to the array.
     */
    public function integer(): self
    {
        return $this->addPrimitive('integer');
    }

    /**
     * Adds a boolean type to the array.
     */
    public function boolean(): self
    {
        return $this->addPrimitive('boolean');
    }

    /**
     * Adds a date type to the array.
     */
    public function date(): self
    {
        return $this->addPrimitive('date');
    }

    /**
     * Adds a datetime type to the array.
     */
    public function dateTime(): self
    {
        return $this->addPrimitive('datetime');
    }

    /**
     * Adds a float type to the array.
     */
    public function float(): self
    {
        return $this->addPrimitive('float');
    }

    /**
     * Adds a byte type to the array.
     */
    public function byte(): self
    {
        return $this->addPrimitive('byte');
    }

    /**
     * Adds a binary type to the array.
     */
    public function binary(): self
    {
        return $this->addPrimitive('binary');
    }

    /**
     * Adds a decimal type to the array.
     */
    public function decimal(): self
    {
        return $this->addPrimitive('decimal');
    }

    /**
     * Adds a reference to the array.
     *
     * @param  string  $reference  The reference type (e.g., 'User').
     */
    public function addReference(string $reference): self
    {
        $this->items[] = [
            'type' => PropertyTypeEnum::REFERENCE->value,
            'subtype' => $reference,
        ];

        return $this;
    }

    /**
     * Adds a nested object schema to the array.
     *
     * @param  \Closure  $callback  A callback to define the nested object schema.
     */
    public function addObject(\Closure $callback): self
    {
        $nestedBuilder = new ObjectSchemaBuilder;
        $callback($nestedBuilder);

        $this->items[] = [
            'type' => PropertyTypeEnum::OBJECT->value,
            'subtype' => $nestedBuilder->toArray()['properties'],
        ];

        return $this;
    }

    /**
     * Returns the array of items.
     *
     * @return array<array{type: string, subtype: mixed}>
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
