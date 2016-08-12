<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class RedirectionException extends HttpException implements RedirectionExceptionInterface
{
    private $url;

    public function __construct($statusCode, $message, $url, \Exception $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
