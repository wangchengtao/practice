<?php


namespace App\Exceptions;

use Exception as BaseException;
use Throwable;

class CustomException extends BaseException
{
    public function __construct($message = "", $code = FAILED, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
