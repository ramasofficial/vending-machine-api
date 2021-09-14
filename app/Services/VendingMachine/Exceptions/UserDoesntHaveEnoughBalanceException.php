<?php

declare(strict_types=1);

namespace App\Services\VendingMachine\Exceptions;

class UserDoesntHaveEnoughBalanceException extends \RuntimeException
{
    private const ERROR_MESSAGE = 'Your balance is lower than product price, insert the money and try again.';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE);
    }
}
