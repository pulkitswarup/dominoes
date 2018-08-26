<?php

namespace Game\Dominoes\Exceptions;

class InvalidDominoTypeException extends DominoesGameException
{
    protected $code = 400;
    protected $message = "Invalid dominoes type";
}