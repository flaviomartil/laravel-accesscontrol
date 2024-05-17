<?php

namespace FlavioMartil\AccessControl\Exceptions;

use http\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AccessControlException extends ValidationException
{
    private $errorType;
    private $statusCode = Response::HTTP_BAD_REQUEST;
    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;
        return $this;
    }

    public function getErrorType()
    {
        return $this->errorType;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public static function tenancyLoad()
    {
        return static::withMessages(['message' => [__('messages.login.tenancy_load_error')]])->setErrorType('TENANCY_LOAD_ERROR');
    }

    public static function accessDenied()
    {
        return static::withMessages(['message' => [ __('messages.access_denied'),]])->setErrorType('ACCESS_DENIED');
    }

}
