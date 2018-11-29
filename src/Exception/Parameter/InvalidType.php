<?php

namespace App\Exception\Parameter;

use App\Exception\AbstractBaseException;

/**
 * Used when a parameter is not a valid type.
 */
class InvalidType extends AbstractBaseException
{
    protected $message = 'The given type is invalid.';
}
