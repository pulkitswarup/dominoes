<?php

namespace Game\Dominoes\Exceptions;

class NoDominoesInSetException extends DominoesGameException
{
    protected $code = 500;
    protected $message = 'There are no dominoes in the set';
}