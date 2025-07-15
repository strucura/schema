<?php

use Strucura\Schema\Builders\ObjectSchemaBuilder;
use Strucura\Schema\Facades\Schema;

it('can create a default schema', function () {
    $schema = Schema::object('object');

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [],
    ]);
});

it('can add string, integer, and boolean properties', function () {
    $schema = Schema::object('object')
        ->string('name', true)
        ->integer('age')
        ->boolean('is_active', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'name' => ['type' => 'primitive', 'subtype' => 'string', 'required' => true],
            'age' => ['type' => 'primitive', 'subtype' => 'integer', 'required' => false],
            'is_active' => ['type' => 'primitive', 'subtype' => 'boolean', 'required' => true],
        ],
    ]);
});

it('can add an array property with nested items', function () {
    $schema = Schema::object('object')
        ->arrayOf('tags', 'string', true);

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
    $schema = Schema::object('object')
        ->arrayOf('addresses', function (ObjectSchemaBuilder $nested) {
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
                        'street' => ['type' => 'primitive', 'subtype' => 'string', 'required' => true],
                        'city' => ['type' => 'primitive', 'subtype' => 'string', 'required' => true],
                    ],
                ],
            ],
        ],
    ]);
});

it('can add an array property with multiple types', function () {
    $schema = Schema::object('object')->arrayOf('is_enabled', ['boolean', 'byte'], true);

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
    $schema = Schema::object('object')->object('address', function (ObjectSchemaBuilder $nested) {
        $nested->string('street', true)
            ->string('city', true);
    });

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'address' => [
                'type' => 'object',
                'required' => false,
                'subtype' => [
                    'street' => ['type' => 'primitive', 'subtype' => 'string', 'required' => true],
                    'city' => ['type' => 'primitive', 'subtype' => 'string', 'required' => true],
                ],
            ],
        ],
    ]);
});

it('can add an enum property', function () {
    $schema = Schema::object('object')->enum('status', ['active', 'inactive'], true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'status' => [
                'type' => 'enum',
                'required' => true,
                'subtype' => ['active', 'inactive'],
            ],
        ],
    ]);
});

it('can add a reference property', function () {
    $schema = Schema::object('object')->reference('user', 'User', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'user' => [
                'type' => 'reference',
                'subtype' => 'User',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a float property', function () {
    $schema = Schema::object('object')->float('price', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'price' => [
                'type' => 'primitive',
                'subtype' => 'float',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a date property', function () {
    $schema = Schema::object('object')->date('created_at', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'created_at' => [
                'type' => 'primitive',
                'subtype' => 'date',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a datetime property', function () {
    $schema = Schema::object('object')->dateTime('updated_at', false);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'updated_at' => [
                'type' => 'primitive',
                'subtype' => 'datetime',
                'required' => false,
            ],
        ],
    ]);
});

it('can add a byte property', function () {
    $schema = Schema::object('object')->byte('file_hash', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'file_hash' => [
                'type' => 'primitive',
                'subtype' => 'byte',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a binary property', function () {
    $schema = Schema::object('object')->binary('file_data', false);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'file_data' => [
                'type' => 'primitive',
                'subtype' => 'binary',
                'required' => false,
            ],
        ],
    ]);
});

it('can add a decimal property', function () {
    $schema = Schema::object('object')->decimal('amount', true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'amount' => [
                'type' => 'primitive',
                'subtype' => 'decimal',
                'required' => true,
            ],
        ],
    ]);
});

it('can add a property with anyOf types', function () {
    $schema = Schema::object('object')
        ->anyOf('mixed_property', ['string', 'integer'], true);

    expect($schema->toArray())->toMatchArray([
        'type' => 'object',
        'properties' => [
            'mixed_property' => [
                'type' => 'anyOf',
                'required' => true,
                'subtype' => ['string', 'integer'],
            ],
        ],
    ]);
});
