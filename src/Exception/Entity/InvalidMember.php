<?php

namespace App\Exception\Entity;

use App\Exception\AbstractBaseException;

/**
 * Used when the given Member is invalid for some reason.
 */
class InvalidMember extends AbstractBaseException
{
    protected $message = 'The given member (maybe in a collection) is invalid.';
}
