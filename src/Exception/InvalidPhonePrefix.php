<?php

namespace App\Exception;

/**
 * User when a parameter is not a valid +phone prefix in the +351 format.
 */
class InvalidPhonePrefix extends \Exception
{
    protected $message = 'The given phone prefix must follow the +351 format.';
}
