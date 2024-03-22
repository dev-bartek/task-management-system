<?php

use Tests\Unit\Data\TestEnum;

it('can output array of names', function () {
    $namesArray = TestEnum::names();

    expect($namesArray)
        ->toBeArray()
        ->toEqual(['FirstName', 'SecondName']);
});

it('can output array of values', function () {
    $valuesArray = TestEnum::values();

    expect($valuesArray)
        ->toBeArray()
        ->toEqual(['first value', 'second value']);
});
