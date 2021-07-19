<?php
namespace ZedMagdy\Bundle\SaasKitBundle\Exceptions;

use Exception;
use Throwable;

class TenantDoesNotExist extends Exception
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}