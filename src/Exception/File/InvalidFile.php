<?php

namespace App\Exception\File;

use App\Exception\AbstractBaseException;

/**
 * Used when a file is invalid for some reason.
 */
class InvalidFile extends AbstractBaseException
{
    protected $message = 'The given file is invalid.';
}
