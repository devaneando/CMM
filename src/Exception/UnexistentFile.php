<?php

namespace App\Exception;

/**
 * User when a parameter is an unexistent file.
 */
class UnexistentFile extends \Exception
{
    protected $message = 'The given file does not exist.';
}
