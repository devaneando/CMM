<?php

namespace App\Exception\Parameter;

use App\Exception\AbstractBaseException;

/**
 * Used when a parameter is not a valid +phone prefix in the +351 format.
 */
class InvalidPhonePrefix extends AbstractBaseException
{
    protected $message = 'The given phone prefix must follow the +351 format.';
}
