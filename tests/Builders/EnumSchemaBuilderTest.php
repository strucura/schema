<?php

use Strucura\Schema\Builders\BackedEnumSchemaBuilder;
use Strucura\Schema\Tests\Mocks\BackedEnum;
use Strucura\Schema\Tests\Mocks\NonBackedEnum;

it('can create a schema for a valid backed enum', function () {
    $builder = new BackedEnumSchemaBuilder(BackedEnum::class);

    expect($builder->toArray())->toMatchArray([
        'type' => 'BackedEnum',
        'enum' => [
            'ACTIVE' => 1,
            'DISABLED' => 2,
        ],
    ]);
});

it('throws an exception for a non-backed enum', function () {
    expect(fn () => new BackedEnumSchemaBuilder(NonBackedEnum::class))
        ->toThrow(\InvalidArgumentException::class, 'The class Strucura\Schema\Tests\Mocks\NonBackedEnum must be a backed enum.');
});

it('can output the correct array representation', function () {
    $builder = new BackedEnumSchemaBuilder(BackedEnum::class);

    $schema = $builder->toArray();

    expect($schema['type'])->toBe('BackedEnum')
        ->and($schema['enum'])->toMatchArray([
            'ACTIVE' => 1,
            'DISABLED' => 2,
        ]);
});
