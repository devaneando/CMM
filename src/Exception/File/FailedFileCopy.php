<?php

namespace App\Exception\File;

use App\Exception\AbstractBaseException;

/**
 * Used when a file copy fails.
 */
class FailedFileCopy extends AbstractBaseException
{
    protected $message = 'Could not copy file.';
}
