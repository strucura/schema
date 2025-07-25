<?php

namespace Strucura\Schema\Properties;

use Strucura\Schema\Enums\PropertyTypeEnum;

class Property
{
    /** @var array<string, mixed> */
    private array $attributes = [];

    public function __construct(
        private readonly PropertyTypeEnum $type,
        private readonly bool $required = false,
    ) {}

    public function setAttribute(string $key, mixed $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(
            [
                'type' => $this->type->value,
                'required' => $this->required,
            ],
            $this->attributes
        );
    }
}
