<?php

namespace App\Exception;

/**
 * User when a parameter is not a valid type.
 */
class InvalidType extends \Exception
{
    protected $message = 'The given type is invalid.';
}
