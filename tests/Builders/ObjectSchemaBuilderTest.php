<?php

use Strucura\Schema\Builders\ObjectSchemaBuilder;
use Strucura\Schema\Enums\PropertyTypeEnum;

it('can create a default schema', function () {
    $schema = new ObjectSchemaBuilder;

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [],
    ]);
});

it('can add string, integer, and boolean properties', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->string('name', true)
        ->integer('age')
        ->boolean('is_active', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'name' => ['type' => 'string', 'required' => true],
            'age' => ['type' => 'integer', 'required' => false],
            'is_active' => ['type' => 'boolean', 'required' => true],
        ],
    ]);
});

it('can add an array property with nested items', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->arrayOf('tags', 'string', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'tags' => [
                'type' => 'arrayOf',
                'required' => true,
                'subtype' => ['string'],
            ],
        ],
    ]);
});

it('can add an array property with object items', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->arrayOf('addresses', function (ObjectSchemaBuilder $nested) {
        $nested->string('street', true)
            ->string('city', true);
    }, true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'addresses' => [
                'type' => 'arrayOf',
                'required' => true,
                'subtype' => [
                    'type' => 'object',
                    'properties' => [
                        'street' => ['type' => 'string', 'required' => true],
                        'city' => ['type' => 'string', 'required' => true],
                    ],
                ],
            ],
        ],
    ]);
});

it('can add an array property with multiple types', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->arrayOf('is_enabled', [PropertyTypeEnum::BOOLEAN, PropertyTypeEnum::BYTE], true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'is_enabled' => [
                'type' => 'arrayOf',
                'required' => true,
                'subtype' => ['boolean', 'byte'],
            ],
        ],
    ]);
});

it('can add an object property with nested schema', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->object('address', function (ObjectSchemaBuilder $nested) {
        $nested->string('street', true)
            ->string('city', true);
    });

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'address' => [
                'type' => 'object',
                'required' => false,
                'properties' => [
                    'street' => ['type' => 'string', 'required' => true],
                    'city' => ['type' => 'string', 'required' => true],
                ],
            ],
        ],
    ]);
});

it('can add an enum property', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->enum('status', ['active', 'inactive'], true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'status' => [
                'type' => 'enum',
                'required' => true,
                'enum' => ['active', 'inactive'],
            ],
        ],
    ]);
});

it('can add a reference property', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->reference('user', 'User', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'user' => [
                'type' => 'User',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a float property', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->float('price', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'price' => [
                'type' => 'float',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a date property', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->date('created_at', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'created_at' => [
                'type' => 'date',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a datetime property', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->dateTime('updated_at', false);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'updated_at' => [
                'type' => 'datetime',
                'required' => false,
            ],
        ],
    ]);
});

it('can add a byte property', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->byte('file_hash', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'file_hash' => [
                'type' => 'byte',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a binary property', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->binary('file_data', false);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'file_data' => [
                'type' => 'binary',
                'required' => false,
            ],
        ],
    ]);
});

it('can add a decimal property', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->decimal('amount', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'amount' => [
                'type' => 'decimal',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a property with anyOf types', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->anyOf('mixed_property', ['string', PropertyTypeEnum::INTEGER->value], true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'mixed_property' => [
                'type' => 'anyOf',
                'required' => true,
                'types' => ['string', 'integer'],
            ],
        ],
    ]);
});
