# create closure libraries with ease for functional programming with php

[![Latest Version on Packagist](https://img.shields.io/packagist/v/inmanturbo/functional-library.svg?style=flat-square)](https://packagist.org/packages/inmanturbo/functional-library)
[![Tests](https://img.shields.io/github/actions/workflow/status/inmanturbo/functional-library/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/inmanturbo/functional-library/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/inmanturbo/functional-library.svg?style=flat-square)](https://packagist.org/packages/inmanturbo/functional-library)

This package makes it easy to export and autoload a library of anonymous functions or collections of anonymous functions using composer.

## Installation

You can install the package via composer:

```bash
composer require inmanturbo/functional-library
```

## Usage

To create a library you can use the `HasFunctionalLibrary`, then you just have to implement
a static library method with name bool parameters for your available functions.

You then call `static::getLibrary` with all your parameters as its `args`.

Finally, you create a static method called `closures()` with an associative array of your anonymous
functions with  (string) keys corresponding to your library method's named params.

## Example

```php
use Inmanturbo\FunctionalLibrary\HasFunctionalLibrary;

class ExampleLibrary
{
    use HasFunctionalLibrary;

    public static function library(bool $addOne = false, bool $addTwo = false)
    {
        return static::getLibrary($addOne, $addTwo);
    }

    public static function closures()
    {
        return [
            'addOne' => fn(int $number): int => $number + 1,
            'addTwo' => fn(int $number): int => $number + 2,
        ];
    }
}
```

## Example Usage

The above example creates the folowing testable api (using pest):

```php
[$addOne, $addTwo] = ExampleLibrary::library(addOne: true, addTwo: true);
expect($addOne(0))->toBe(1);
expect($addTwo(0))->toBe(2);

// Test a single option
$addOne = ExampleLibrary::library(addOne: true);

expect($addOne(0))->toBe(1);

// Test no options (should return all available options)
[$addOne, $addTwo] = ExampleLibrary::library();

expect($addOne(0))->toBe(1);
expect($addTwo(0))->toBe(2);
```

Now you can put your `helper` functions into scoped libraries and find them using static analysis by their named arguments.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [inmanturbo](https://github.com/inmanturbo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
