<?php

use Inmanturbo\FunctionalLibrary\HasFunctionalLibrary;

test('it can make a library', function (): void {
    [$addOne, $addTwo] = Library::library(addOne: true, addTwo: true);
    expect($addOne(0))->toBe(1);
    expect($addTwo(0))->toBe(2);

    [$addOne, $addTwo] = Library::getLibrary(...[true, true]);

    expect($addOne(0))->toBe(1);
    expect($addTwo(0))->toBe(2);

    // Test a single option
    $addOne = Library::library(addOne: true);
    expect($addOne(0))->toBe(1);

    // Test no options (should return all available options)
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

    public static function closures()
    {
        return [
            'addOne' => fn(int $number): int => $number + 1,
            'addTwo' => fn(int $number): int => $number + 2,
        ];
    }
}
