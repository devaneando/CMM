<?php

namespace App\Exception\Entity;

use App\Exception\AbstractBaseException;

/**
 * Used when no object was found with a given slug.
 */
class UnexistentSlug extends AbstractBaseException
{
    protected $message = 'Nothing was found with the given slug.';
}
