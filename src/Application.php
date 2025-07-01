<?php

namespace Onetech\XhsAgoraSdk;

final class Application
{

    private array $instances;

    public function __construct(private readonly Configuration $configuration, private readonly HttpFactory $httpFactory)
    {
    }

    public static function create(Configuration $configuration): self
    {
        return new self($configuration, new HttpFactory($configuration));
    }

    public function configuration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return OAuth
     */
    public function oAuth(): OAuth
    {
        return $this->instantiateSDK(OAuth::class);
    }

    /**
     * @param string $sdkClass
     * @return object
     */
    private function instantiateSDK(string $sdkClass): object
    {
        if (isset($this->instances[$sdkClass])) {
            return $this->instances[$sdkClass];
        }

        $this->instances[$sdkClass] = new $sdkClass($this->configuration, $this->httpFactory);

        return $this->instances[$sdkClass];
    }

}