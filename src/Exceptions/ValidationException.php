<?php

namespace Game\Dominoes\Exceptions;

class ValidationException extends DominoesGameException
{
    protected $code = 400;
    protected $message = "game validation failed";
}