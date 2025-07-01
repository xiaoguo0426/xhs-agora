<?php

declare(strict_types=1);

namespace Onetech\XhsAgoraSdk;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

final class HttpFactory
{
    const API_DOMAIN = 'https://edith.xiaohongshu.com';

    public function __construct(private readonly Configuration $configuration)
    {
    }

    public function createRequest(): \GuzzleHttp\Client
    {
        $options = $this->configuration->getHttpOption();
        return new \GuzzleHttp\Client(array_merge([
            'base_uri' => self::API_DOMAIN,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ], $options));
    }

    /**
     * @param string $uri
     * @param array $data
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function post(string $uri, array $data): ResponseInterface
    {
        $request = new Request('POST', $uri,
            [],
            json_encode($data));

        return $this->createRequest()->send($request);
    }

    /**
     * @param $uri
     * @param array $data
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get($uri, array $data): ResponseInterface
    {
        return $this->createRequest()->request('GET', $uri, ['query' => $data]);
    }
}
