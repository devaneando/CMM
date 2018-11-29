<?php

namespace App\Exception\Parameter;

use App\Exception\AbstractBaseException;

/**
 * Used when a parameter is not a valid gender.
 */
class InvalidGender extends AbstractBaseException
{
    protected $message = 'The given gender is invalid.';
}
