<?php

namespace Onetech\XhsAgoraSdk;

use GuzzleHttp\Client as HttpClient;

class Client
{
    protected $appId; // 在签名逻辑中作为 appKey
    protected $appSecret;
    protected $httpClient;
    protected $baseUrl = 'https://agora.xiaohongshu.com'; // 请根据文档确认基础 URL

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->httpClient = new HttpClient([
            'base_uri' => $this->baseUrl,
            'timeout'  => 5.0,
        ]);
    }

    /**
     * 获取 access_token
     * 注意：此实现基于签名逻辑推断，请根据小红书官方文档核对URL和请求/响应参数
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function getAccessToken()
    {
        // 假设的接口路径，请根据文档修改
        $uri = '/api/v1/token';

        $nonce = bin2hex(random_bytes(16)); // 生成一个随机字符串
        $timeStamp = (string)(int)(microtime(true) * 1000); // 毫秒级时间戳

        $signature = $this->buildSignature($nonce, $timeStamp, $this->appSecret);

        $response = $this->httpClient->post($uri, [
            'json' => [
                'appKey' => $this->appId,
                'nonce' => $nonce,
                'timeStamp' => $timeStamp,
                'signature' => $signature,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        // 假设返回的 JSON 中有 access_token 字段
        if (isset($body['access_token'])) {
            return $body['access_token'];
        }

        // 根据实际错误信息抛出异常
        $errorMessage = $body['msg'] ?? 'Failed to get access token.';
        throw new \Exception($errorMessage);
    }

    /**
     * 构建签名所需参数并发起签名
     * @param string $nonce 随机字符串
     * @param string $timeStamp 毫秒级时间戳
     * @param string $secret 用于签名的密钥 (可能是 appSecret 或 access_token)
     * @return string
     */
    public function buildSignature(string $nonce, string $timeStamp, string $secret): string
    {
        $params = [
            'appKey' => $this->appId,
            'nonce' => $nonce,
            'timeStamp' => $timeStamp,
        ];
        return $this->generateSignature($secret, $params);
    }

    /**
     * 生成签名 (PHP 版本实现)
     * @param string $secretKey 密钥
     * @param array $params 加签参数
     * @return string 签名
     */
    public function generateSignature(string $secretKey, array $params): string
    {
        // Step 1: 按 key 排序参数
        ksort($params);

        // Step 2: 拼接排序后的参数
        $paramsString = '';
        foreach ($params as $key => $value) {
            if ($paramsString !== '') {
                $paramsString .= '&';
            }
            $paramsString .= $key . '=' . $value;
        }

        // Step 3: 在参数字符串后追加密钥
        $paramsString .= $secretKey;

        // Step 4: 使用 SHA-256 计算签名并返回小写十六进制值
        return hash('sha256', $paramsString);
    }
} 