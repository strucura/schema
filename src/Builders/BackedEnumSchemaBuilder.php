<?php

namespace Strucura\Schema\Builders;

use BackedEnum;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;

class BackedEnumSchemaBuilder
{
    use Macroable;

    private string $type;

    /** @var array<string, int|float|string> */
    private array $subtype = [];

    public function __construct(string $enumClass)
    {
        if (! is_subclass_of($enumClass, BackedEnum::class)) {
            throw new \InvalidArgumentException("The class {$enumClass} must be a backed enum.");
        }

        $this->type = Str::of($enumClass)->classBasename()->toString();

        /** @var array<string, int|float|string> $enumValues */
        $enumValues = array_reduce(
            $enumClass::cases(),
            fn (array $carry, BackedEnum $enum) => $carry + [$enum->name => $enum->value],
            []
        );

        $this->subtype = $enumValues;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'subtype' => $this->subtype,
        ];
    }
}
