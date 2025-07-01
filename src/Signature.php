<?php

namespace Onetech\XhsAgoraSdk;

use InvalidArgumentException;
use Random\RandomException;

final readonly class Signature
{
    /**
     * 生成签名
     * @param string $app_key
     * @param string $nonce
     * @param int $timestamp
     * @param string $secret_or_token
     * @return string
     */
    public static function build(string $app_key, string $nonce, int $timestamp, string $secret_or_token): string
    {
        //如何限制参数不能是空串
        if (empty($app_key) || empty($nonce) || empty($timestamp) || empty($secret_or_token)) {
            throw new InvalidArgumentException('参数不能为空');
        }

        $params = [
            'appKey' => $app_key,
            'nonce' => $nonce,
            'timeStamp' => $timestamp,
        ];
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
        $paramsString .= $secret_or_token;

        // Step 4: 使用 SHA-256 计算签名并返回小写十六进制值
        return hash('sha256', $paramsString);
    }

    /**
     * 生成随机数字符串
     * @return string
     */
    public static function genRandomStr(): string
    {
        try {
            return bin2hex(random_bytes(16));
        }catch (RandomException){
        }

        if (extension_loaded('openssl')){
            return bin2hex(openssl_random_pseudo_bytes(16));
        }

        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 5)), 0, 32);

    }

}