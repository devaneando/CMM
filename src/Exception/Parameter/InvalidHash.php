<?php

namespace App\Exception\Parameter;

use App\Exception\AbstractBaseException;

/**
 * Used when a parameter is not a valid hash.
 */
class InvalidHash extends AbstractBaseException
{
    protected $message = 'The given hash is invalid.';
}
