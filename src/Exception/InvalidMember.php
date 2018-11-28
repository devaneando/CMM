<?php

namespace App\Exception;

/**
 * User when a parameter is not a valid member.
 */
class InvalidMember extends \Exception
{
    protected $message = 'The given member (maybe in a collection) is invalid.';
}
