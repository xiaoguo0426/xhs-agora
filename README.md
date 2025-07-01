# 小红书 Agora 平台 PHP SDK

这是一个用于与小红书 Agora 开放平台进行交互的 PHP SDK。

## 安装

通过 Composer 安装:

```bash
composer require xhs/agora-sdk
```

## 使用方法

### 获取 Access Token
```php
<?php

use GuzzleHttp\Exception\GuzzleException;
use Onetech\XhsAgoraSdk\Application;
use Onetech\XhsAgoraSdk\Configuration;
use Onetech\XhsAgoraSdk\Exception\ApiException;

require __DIR__ . '/../vendor/autoload.php';


$app_key = '';
$app_secret = '';

$configuration = Configuration::create($app_key, $app_secret);

$app = Application::create($configuration);
$oAuth = $app->oAuth();
try {
    $accessToken = $oAuth->getAccessToken();
    var_dump($accessToken->token());
    var_dump($accessToken->expiresIn());
    //将access_token保存起来，下次请求时使用。需要使用者自行维护access_token的有效期。
} catch (GuzzleException|ApiException|JsonException $e) {
}
```

### 生成分享签名

```php


$app_key = '';
//$app_secret = '';

$access_token = '';

$nonce = Signature::genRandomStr();
$timestamp = round(microtime(true) * 1000);

$signature = Signature::build($app_key, $nonce, $timestamp, $access_token);//生成分享签名

var_dump($signature);

```