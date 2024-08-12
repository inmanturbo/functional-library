<?php

use Inmanturbo\FunctionalLibrary\HasFunctionalLibrary;

test('it can make a library', function () {
    [$addOne, $addTwo] = Library::library(addOne: true, addTwo: true);
    expect($addOne(0))->toBe(1);
    expect($addTwo(0))->toBe(2);

    // Testing with a single option
    $addOne = Library::library(addOne: true);
    expect($addOne(0))->toBe(1);

    // Testing with no options (should return all available options)
    [$addOne, $addTwo] = Library::library();
    expect($addOne(0))->toBe(1);
    expect($addTwo(0))->toBe(2);
});

class Library
{
    use HasFunctionalLibrary;

    public static function library(bool $addOne = false, bool $addTwo = false)
    {
        return static::getLibrary($addOne, $addTwo);
    }

    public static function closures(): array
    {
        return [
            'addOne' => function (int $number): int {
                return $number + 1;
            },
            'addTwo' => function (int $number): int {
                return $number + 2;
            },
        ];
    }
}
