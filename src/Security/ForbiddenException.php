<?php
namespace App\Security;

use Exception;

class ForbiddenException extends Exception
{
    public function __construct()
    {
        $this->message = "Vous n'avez pas le droit d'accéder à cette page";
        $this->code = 403;
    }
}