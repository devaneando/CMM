<?php

namespace App\Exception;

/**
 * User when a parameter is not a valid gender.
 */
class InvalidGender extends \Exception
{
    protected $message = 'The given gender is invalid.';
}
