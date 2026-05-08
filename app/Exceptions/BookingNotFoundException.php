<?php

namespace App\Exceptions;

use RuntimeException;

class BookingNotFoundException extends RuntimeException
{
    public static function forId(string $bookingId): self
    {
        return new self("Booking dengan ID {$bookingId} tidak ditemukan.");
    }
}
