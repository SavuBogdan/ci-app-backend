<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DockerCommandException extends Exception
{

    public function __construct(string $command, int $code = 0, Throwable $previous = null)
    {
        $message = "Error while running command: $command";
        parent::__construct($message, $code, $previous);
    }
}