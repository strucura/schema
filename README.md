# Schema

[![Latest Version on Packagist](https://img.shields.io/packagist/v/strucura/schema.svg?style=flat-square)](https://packagist.org/packages/strucura/schema)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/strucura/schema/run-tests.yml?branch=0.x&label=tests&style=flat-square)](https://github.com/strucura/schema/actions?query=workflow%3Arun-tests+branch%3A0.x)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/strucura/schema/fix-php-code-style-issues.yml?branch=0.x&label=code%20style&style=flat-square)](https://github.com/strucura/schema/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3A0.x)
[![Total Downloads](https://img.shields.io/packagist/dt/strucura/schema.svg?style=flat-square)](https://packagist.org/packages/strucura/schema)

> [!WARNING]  
> This is not ready for production usage.

The Schema package provides a flexible and intuitive way to define and manage data schemas in PHP. It allows developers to create structured schemas with various property types, including strings, integers, booleans, arrays, objects, and enums. The package supports nested schemas, inline enums, and backed enums, making it ideal for building complex data structures. Designed for Laravel, it integrates seamlessly with the framework and includes tools for configuration, migrations, and views.

## Installation

You can install the package via composer:

```bash
composer require strucura/schema
```

## Usage

```php
<?php

use Strucura\Schema\Facades\Schema;
use Strucura\Schema\Enums\PropertyTypeEnum;

// Create an object schema
$schema = Schema::object()
    // Add properties to the schema
    ->string('name', true) // Required string property
    ->integer('age', false) // Optional integer property
    ->enum('status', ['active', 'inactive'], true) // Required enum property
    ->float('price', true) // Required float property
    ->date('created_at', true) // Required date property
    ->anyOf('mixed_property', ['string', PropertyTypeEnum::INTEGER->value], true); // Required anyOf property
    ->object('address', function ($nested) {
        $nested->string('street', true);
        $nested->string('city', true);
    }, false); // Optional nested object

// Convert the schema to an array
$schemaArray = $schema->toArray();

// Output the schema
print_r($schemaArray);

// Renders
[
    'type' => 'object',
    'properties' => [
        'name' => [
            'type' => 'string',
            'required' => true,
        ],
        'age' => [
            'type' => 'integer',
            'required' => false,
        ],
        'status' => [
            'type' => 'enum',
            'required' => true,
            'enum' => ['active', 'inactive'],
        ],
        'price' => [
            'type' => 'float',
            'required' => true,
        ],
        'created_at' => [
            'type' => 'date',
            'required' => true,
        ],
        'mixed_property' => [
            'type' => 'anyOf',
            'required' => true,
            'subtype' => ['string', 'integer'],
        ],
        'address' => [
            'type' => 'object',
            'required' => false,
            'properties' => [
                'street' => [
                    'type' => 'string',
                    'required' => true,
                ],
                'city' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
        ],
    ],
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Andrew Leach](https://github.com/7387639+andyleach)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
