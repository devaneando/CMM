<?php

namespace App\Exception\Image;

use App\Exception\AbstractBaseException;

/**
 * User when an image is corrupted.
 */
class CorruptedImageFile extends AbstractBaseException
{
    protected $message = 'The given image is corrupted.';
}
