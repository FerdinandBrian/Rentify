<?php

namespace App\Exceptions;

use RuntimeException;

class DocumentNotVerifiedException extends RuntimeException
{
    public static function forUser(): self
    {
        return new self('Anda harus memiliki minimal satu dokumen yang telah diverifikasi sebelum dapat melakukan pemesanan.');
    }
}
