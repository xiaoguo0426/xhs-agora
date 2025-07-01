<?php

namespace Onetech\XhsAgoraSdk;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Onetech\XhsAgoraSdk\Exception\ApiException;
use Random\RandomException;

final readonly class OAuth
{
    public function __construct(private Configuration $configuration, private HttpFactory $httpFactory)
    {
    }

    /**
     * @return AccessToken
     * @throws ApiException
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getAccessToken(): AccessToken
    {
        $app_key = $this->configuration->getAppKey();
        $app_secret = $this->configuration->getAppSecret();

        $uri = '/api/sns/v1/ext/access/token';

        $nonce = Signature::genRandomStr();
        $timestamp = (int)round(microtime(true) * 1000);

        $signature = Signature::build($app_key, $nonce, $timestamp, $app_secret);

        $expires_in = time() + 24 * 60 * 60;

        $response = $this->httpFactory->post($uri, [
            'app_key' => $app_key,
            'nonce' => $nonce,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'expires_in' => $expires_in
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new ApiException(\sprintf(
                '[%d] Error connecting to the API (%s)',
                $response->getStatusCode(),
                $uri,
            ), $response->getStatusCode());
        }
        return AccessToken::fromJson(trim($response->getBody()->getContents(), "\n\r\t"));
    }

}