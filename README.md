# Schema

[![Latest Version on Packagist](https://img.shields.io/packagist/v/strucura/schema.svg?style=flat-square)](https://packagist.org/packages/strucura/schema)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/strucura/schema/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/strucura/schema/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/strucura/schema/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/strucura/schema/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/strucura/schema.svg?style=flat-square)](https://packagist.org/packages/strucura/schema)

The Strucura Schema package provides a flexible and intuitive way to define and manage data schemas in PHP. It allows developers to create structured schemas with various property types, including strings, integers, booleans, arrays, objects, and enums. The package supports nested schemas, inline enums, and backed enums, making it ideal for building complex data structures. Designed for Laravel, it integrates seamlessly with the framework and includes tools for configuration, migrations, and views.

## Installation

You can install the package via composer:

```bash
composer require strucura/schema
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="schema-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="schema-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="schema-views"
```

## Usage

```php
$schema = new Strucura\Schema();
echo $schema->echoPhrase('Hello, Strucura!');
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
