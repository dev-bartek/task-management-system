<?php

use App\Enums\UserTypes;
use App\Models\User;

it('can determine if user is admin', function () {
    $user = User::factory()->make();

    expect($user->type)
        ->toBeInstanceOf(UserTypes::class)
        ->toEqual(UserTypes::User)
        ->and($user->isAdmin())
        ->toBeFalse();

    $user = User::factory()->admin()->make();

    expect($user->isAdmin())->toBeTrue();
});
