<?php

use Onetech\XhsAgoraSdk\Signature;

require __DIR__ . '/../vendor/autoload.php';


$app_key = '';
//$app_secret = '';

$access_token = '';

$nonce = Signature::genRandomStr();
$timestamp = (int)round(microtime(true) * 1000);

$signature = Signature::build($app_key, $nonce, $timestamp, $access_token);//生成分享签名

var_dump($signature);
