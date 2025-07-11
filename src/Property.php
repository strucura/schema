<?php

namespace Strucura\Schema;

class Property
{
    private array $attributes = [];

    public function __construct(
        private readonly string $type,
        private readonly bool $required = false
    ) {}

    public function setAttribute(string $key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function toArray(): array
    {
        return array_merge(
            [
                'type' => $this->type,
                'required' => $this->required,
            ],
            $this->attributes
        );
    }
}
