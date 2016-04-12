<?php

namespace App\Exceptions;

use Exception;

class SocialException extends Exception
{
    public $errorCode = 16;

    public $extra = [];

    public function __construct(
        $message = null,
        $code = 0,
        array $extra = [],
        Exception $previous = null
    ) {
        $this->extra = $extra;

        parent::__construct($message, $code, $previous);
    }
}
