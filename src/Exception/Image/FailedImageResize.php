<?php

namespace App\Exception\Image;

use App\Exception\AbstractBaseException;

/**
 * Used when an image could not be resized.
 */
class FailedImageResize extends AbstractBaseException
{
    protected $message = 'Could not resize the given image.';
}
