<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ContainerCreationException extends Exception
{
    public function __construct(string $message = 'Container creation failed', int $code = 1, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}