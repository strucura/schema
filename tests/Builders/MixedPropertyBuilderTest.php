<?php

use Strucura\Schema\Builders\MixedPropertyBuilder;
use Strucura\Schema\Enums\PropertyTypeEnum;

it('can add a string primitive to the array', function () {
    $builder = new MixedPropertyBuilder;
    $builder->string();

    expect($builder->toArray())->toMatchArray([
        [
            'type' => PropertyTypeEnum::PRIMITIVE->value,
            'subtype' => 'string',
        ],
    ]);
});

it('can add multiple primitives to the array', function () {
    $builder = new \Strucura\Schema\Builders\MixedPropertyBuilder;
    $builder->string()->integer()->boolean();

    expect($builder->toArray())->toMatchArray([
        [
            'type' => PropertyTypeEnum::PRIMITIVE->value,
            'subtype' => 'string',
        ],
        [
            'type' => PropertyTypeEnum::PRIMITIVE->value,
            'subtype' => 'integer',
        ],
        [
            'type' => PropertyTypeEnum::PRIMITIVE->value,
            'subtype' => 'boolean',
        ],
    ]);
});

it('can add a reference to the array', function () {
    $builder = new MixedPropertyBuilder;
    $builder->addReference('User');

    expect($builder->toArray())->toMatchArray([
        [
            'type' => PropertyTypeEnum::REFERENCE->value,
            'subtype' => 'User',
        ],
    ]);
});

it('can add a nested object to the array', function () {
    $builder = new MixedPropertyBuilder;
    $builder->addObject(function ($nested) {
        $nested->string('name', true)->integer('age', false);
    });

    expect($builder->toArray())->toMatchArray([
        [
            'type' => PropertyTypeEnum::OBJECT->value,
            'subtype' => [
                'name' => [
                    'type' => PropertyTypeEnum::PRIMITIVE->value,
                    'subtype' => 'string',
                    'required' => true,
                ],
                'age' => [
                    'type' => PropertyTypeEnum::PRIMITIVE->value,
                    'subtype' => 'integer',
                    'required' => false,
                ],
            ],
        ],
    ]);
});

it('can handle a mix of primitives, references, and objects', function () {
    $builder = new MixedPropertyBuilder;
    $builder->string()
        ->addReference('User')
        ->addObject(function ($nested) {
            $nested->boolean('is_active', true);
        });

    expect($builder->toArray())->toMatchArray([
        [
            'type' => PropertyTypeEnum::PRIMITIVE->value,
            'subtype' => 'string',
        ],
        [
            'type' => PropertyTypeEnum::REFERENCE->value,
            'subtype' => 'User',
        ],
        [
            'type' => PropertyTypeEnum::OBJECT->value,
            'subtype' => [
                'is_active' => [
                    'type' => PropertyTypeEnum::PRIMITIVE->value,
                    'subtype' => 'boolean',
                    'required' => true,
                ],
            ],
        ],
    ]);
});
