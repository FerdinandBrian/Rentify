<?php

namespace App\Exceptions;

use InvalidArgumentException;

class InvalidFilterException extends InvalidArgumentException
{
    public static function status(string $status): self
    {
        return new self("Filter status '{$status}' tidak valid.");
    }
}
