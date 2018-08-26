<?php

namespace Game\Dominoes\Exceptions;

class DominoNotFoundException extends DominoesGameException {
    protected $code = 404;
    protected $message = "Domino Not Found";
}
