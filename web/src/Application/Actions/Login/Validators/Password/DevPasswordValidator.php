<?php

declare(strict_types=1);

namespace App\Application\Actions\Login\Validators\Password;

use App\Domain\Login\PasswordValidatorInterface;

final class DevPasswordValidator implements PasswordValidatorInterface
{
    public function valid(string $password): bool
    {
        return preg_match("/^.+$/", $password) === 1;
    }

    public function criteria(): string
    {
        return "Password must be at least</br> 1 character long.";
    }
}