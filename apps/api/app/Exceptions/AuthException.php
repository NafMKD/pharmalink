<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    public function __construct(string $message = "Authentication error", int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
