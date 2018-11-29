<?php

namespace App\Exception\Image;

use App\Exception\AbstractBaseException;

/**
 * Used when the given image is invalid for some reason.
 */
class InvalidImage extends AbstractBaseException
{
    protected $message = 'The given image is invalid.';
}
