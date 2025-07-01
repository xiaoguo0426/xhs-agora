<?php

namespace Onetech\XhsAgoraSdk;

use JsonException;

final readonly class AccessToken
{

    public function __construct(private string $access_token, private int $expires_in)
    {
    }

    public function token(): string
    {
        return $this->access_token;
    }

    public function expiresIn(): int
    {
        return $this->expires_in;
    }

    /**
     *  解析 AccessToken
     * @param string $json
     * @return self
     * @throws JsonException
     */
    public static function fromJSON(string $json): self
    {
        $data = \json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $d = $data['data'];

        return new self(
            $d['access_token'],
            (int)substr($d['expires_in'], 0, 10),
        );
    }

}