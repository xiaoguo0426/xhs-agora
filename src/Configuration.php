<?php

namespace Onetech\XhsAgoraSdk;

class Configuration
{

    public function __construct(private readonly string $app_key, private readonly string $app_secret, private readonly array $options = [])
    {
    }

    public static function create(string $app_key, string $app_secret): self
    {
        return new self($app_key, $app_secret);
    }

    public function getAppKey(): string
    {
        return $this->app_key;
    }

    public function getAppSecret(): string
    {
        return $this->app_secret;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getHttpOption()
    {
        return $this->options['http'] ?? [];
    }

}