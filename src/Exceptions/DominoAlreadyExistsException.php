<?php

namespace Game\Dominoes\Exceptions;

class DominoAlreadyExistsException extends DominoesGameException
{
    protected $code = 400;
    protected $message = "Dominoes already exists";
}