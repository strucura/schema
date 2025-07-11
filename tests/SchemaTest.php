<?php

use Strucura\Schema\Builders\BackedEnumSchemaBuilder;
use Strucura\Schema\Builders\ObjectSchemaBuilder;
use Strucura\Schema\Schema;
use Strucura\Schema\Tests\Mocks\BackedEnum;

it('can create an object schema builder', function () {
    $schema = new Schema;

    $objectBuilder = $schema->object();

    expect($objectBuilder)->toBeInstanceOf(ObjectSchemaBuilder::class);
});

it('can create a backed enum schema builder', function () {
    $schema = new Schema;

    $enumBuilder = $schema->enum(BackedEnum::class);

    expect($enumBuilder)->toBeInstanceOf(BackedEnumSchemaBuilder::class)
        ->and($enumBuilder->toArray())->toMatchArray([
            'type' => 'BackedEnum',
            'enum' => [
                'ACTIVE' => 1,
                'DISABLED' => 2,
            ],
        ]);
});

it('throws an exception for a non-backed enum in the enum method', function () {
    $schema = new Schema;

    enum NonBackedEnum
    {
        case OPTION_ONE;
        case OPTION_TWO;
    }

    expect(fn () => $schema->enum(NonBackedEnum::class))
        ->toThrow(\InvalidArgumentException::class, 'The class NonBackedEnum must be a backed enum.');
});
