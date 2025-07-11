<?php

use Strucura\Schema\Builders\ObjectSchemaBuilder;

it('can create a default schema', function () {
    $schema = new ObjectSchemaBuilder;

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [],
    ]);
});

it('can add string, integer, and boolean properties', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->addString('name', true)
        ->addInteger('age')
        ->addBoolean('is_active', true);

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
    $schema->addArray('tags', 'string', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'tags' => [
                'type' => 'array',
                'required' => true,
                'items' => ['type' => 'string'],
            ],
        ],
    ]);
});

it('can add an object property with nested schema', function () {
    $schema = new ObjectSchemaBuilder;
    $schema->addObject('address', function (ObjectSchemaBuilder $nested) {
        $nested->addString('street', true)
            ->addString('city', true);
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
    $schema->addEnum('status', 'string', ['active', 'inactive'], true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'status' => [
                'type' => 'string',
                'required' => true,
                'enum' => ['active', 'inactive'],
            ],
        ],
    ]);
});
