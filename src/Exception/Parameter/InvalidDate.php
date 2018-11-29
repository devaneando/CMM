<?php

namespace App\Exception\Parameter;

use App\Exception\AbstractBaseException;

/**
 * Used when a parameter is not a valid date for some reason.
 */
class InvalidDate extends AbstractBaseException
{
    protected $message = 'The given date is invalid.';
}
