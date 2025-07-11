<?php

namespace Strucura\Schema;

class Property
{
    private string $type;

    private array $attributes = [];

    private bool $required = false;

    public function __construct(string $type, bool $required = false)
    {
        $this->type = $type;
        $this->required = $required;
    }

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
