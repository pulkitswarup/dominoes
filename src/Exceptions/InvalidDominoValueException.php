<?php

namespace Game\Dominoes\Exceptions;

class InvalidDominoValueException extends DominoesGameException
{
    protected $code = 400;
    protected $message = "Invalid domino value";
}