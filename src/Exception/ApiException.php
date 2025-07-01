<?php

namespace Onetech\XhsAgoraSdk\Exception;

use Throwable;

final class ApiException extends \Exception
{
    /**
     * The deserialized response object.
     */
    protected null|\stdClass|string $responseObject = null;

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previousException
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previousException = null)
    {
        parent::__construct($message, $code, $previousException);
    }

    /**
     * Gets the HTTP response header.
     *
     * @return null|string[] HTTP response header
     */
    public function getResponseHeaders() : ?array
    {
        return $this->responseHeaders;
    }

    /**
     * Gets the HTTP body of the server response either as Json or string.
     *
     * @return null|\stdClass|string HTTP body of the server response either as \stdClass or string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Sets the deseralized response object (during deserialization).
     *
     * @param \stdClass|string $obj Deserialized response object
     */
    public function setResponseObject(\stdClass|string $obj) : void
    {
        $this->responseObject = $obj;
    }

    /**
     * Gets the deseralized response object (during deserialization).
     *
     * @return null|\stdClass|string the deserialized response object
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }
}