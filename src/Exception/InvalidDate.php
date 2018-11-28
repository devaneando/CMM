<?php

namespace App\Exception;

/**
 * User when a parameter is not a valid date for some reason.
 */
class InvalidDate extends \Exception
{
    protected $message = 'The given date is invalid.';
}
