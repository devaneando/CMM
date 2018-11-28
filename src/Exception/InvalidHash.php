<?php

namespace App\Exception;

/**
 * User when a parameter is not a valid hash.
 */
class InvalidHash extends \Exception
{
    protected $message = 'The given hash is invalid.';
}
