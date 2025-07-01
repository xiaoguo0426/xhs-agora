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
} catch (GuzzleException|ApiException|JsonException $e) {
}
