<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class VolumeCopyException extends Exception
{

    public function __construct(string $message = 'Volume copying failed', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}