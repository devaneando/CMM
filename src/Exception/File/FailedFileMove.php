<?php

namespace App\Exception\File;

use App\Exception\AbstractBaseException;

/**
 * Used when a file move or rename fails.
 */
class FailedFileMove extends AbstractBaseException
{
    protected $message = 'Could not move or rename file.';
}
