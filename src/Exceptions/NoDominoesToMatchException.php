<?php

namespace Game\Dominoes\Exceptions;

class NoDominoesToMatchException extends DominoesGameException
{
    protected $code = 500;
    protected $message = "There are dominoes to match with the player";
}