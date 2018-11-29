<?php

namespace App\Exception;

/**
 * Base class for other exceptions.
 */
abstract class AbstractBaseException extends \Exception
{
    public function __construct(
        \Throwable $previous = null,
        string $message = '',
        int $code = 0
    ) {
        if (false === empty($message)) {
            $this->message = $message;
        }
        parent::__construct($this->message, $code, $previous);
    }
}
