<?php

namespace App\Exception;

/**
 * User when an image is corrupted.
 */
class CorruptedImageFile extends \Exception
{
    protected $message = 'The given image is corrupted.';
}
