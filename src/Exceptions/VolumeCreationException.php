<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class VolumeCreationException extends Exception
{

    public function __construct(string $message = 'Volume creation failed', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}