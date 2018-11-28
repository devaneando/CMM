<?php

namespace App\Exception;

class InvalidFile extends \Exception
{
    protected $message = 'The given file is invalid or does no exist.';
}
