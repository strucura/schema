<?php

use Strucura\Schema\Enums\PropertyTypeEnum;
use Strucura\Schema\Properties\Property;

it('can create a property with type and required flag', function () {
    $property = new Property(PropertyTypeEnum::PRIMITIVE, true);

    expect($property->isRequired())->toBeTrue();
    expect($property->toArray())->toMatchArray([
        'type' => 'primitive',
        'required' => true,
    ]);
});

it('can set attributes', function () {
    $property = new Property(PropertyTypeEnum::PRIMITIVE);
    $property->setAttribute('subtype', 'integer');

    expect($property->toArray())->toMatchArray([
        'type' => 'primitive',
        'subtype' => 'integer',
        'required' => false,
    ]);
});

it('can check if property is required', function () {
    $property = new Property(PropertyTypeEnum::PRIMITIVE, true);

    expect($property->isRequired())->toBeTrue();
});

it('can convert property to array', function () {
    $property = new Property(PropertyTypeEnum::ARRAY_OF);
    $property->setAttribute('items', ['type' => 'string']);

    expect($property->toArray())->toMatchArray([
        'type' => 'arrayOf',
        'required' => false,
        'items' => ['type' => 'string'],
    ]);
});
