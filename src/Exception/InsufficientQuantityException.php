<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class InsufficientQuantityException extends Exception
{
    public function __construct()
    {
        parent::__construct('{"message": "Insufficient item quantity"}');
    }
}