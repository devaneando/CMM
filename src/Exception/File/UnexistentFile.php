<?php

namespace App\Exception\File;

use App\Exception\AbstractBaseException;

/**
 * Used when the given file does not exist on the file system.
 */
class UnexistentFile extends AbstractBaseException
{
    protected $message = 'The given file does not exist.';
}
