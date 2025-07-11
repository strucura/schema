<?php

use Strucura\Schema\Property;

it('can create a property with type and required flag', function () {
    $property = new Property('string', true);

    expect($property->isRequired())->toBeTrue();
    expect($property->toArray())->toMatchArray([
        'type' => 'string',
        'required' => true,
    ]);
});

it('can set attributes', function () {
    $property = new Property('integer');
    $property->setAttribute('min', 1)->setAttribute('max', 10);

    expect($property->toArray())->toMatchArray([
        'type' => 'integer',
        'required' => false,
        'min' => 1,
        'max' => 10,
    ]);
});

it('can check if property is required', function () {
    $property = new Property('boolean', true);

    expect($property->isRequired())->toBeTrue();
});

it('can convert property to array', function () {
    $property = new Property('array', false);
    $property->setAttribute('items', ['type' => 'string']);

    expect($property->toArray())->toMatchArray([
        'type' => 'array',
        'required' => false,
        'items' => ['type' => 'string'],
    ]);
});
