<?php

namespace Game\Dominoes\Exceptions;

class NoDominoesOnTheBoardException extends DominoesGameException
{
    protected $code = 500;
    protected $message = 'There are no dominoes on the board';
}