<?php

namespace App\Exceptions;

use Exception;

class DuplicateLeadException extends Exception
{
    protected $message = 'Заявка уже принята. Перезвоним!';
}