<?php

namespace App\Exception;

/**
 * User when a parameter is not a valid image for some reason.
 */
class InvalidImage extends \Exception
{
    protected $message = 'The given image is invalid.';
}
