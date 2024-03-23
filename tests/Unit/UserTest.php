<?php

use App\Enums\UserType;
use App\Models\User;

it('can determine if user is admin', function () {
    $user = User::factory()->make();

    expect($user->type)
        ->toBeInstanceOf(UserType::class)
        ->toEqual(UserType::User)
        ->and($user->isAdmin())
        ->toBeFalse();

    $user = User::factory()->admin()->make();

    expect($user->isAdmin())->toBeTrue();
});
