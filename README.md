# 小红书 Agora 平台 PHP SDK

这是一个用于与小红书 Agora 开放平台进行交互的 PHP SDK。

## 安装

通过 Composer 安装:

```bash
composer require xhs/agora-sdk
```

## 使用方法

### 1. 初始化客户端

首先，你需要使用你的 `App ID` 和 `App Secret` 来实例化客户端。

```php
require_once 'vendor/autoload.php';

use Xhs\Agora\Client;

$appId = '你的 App ID';
$appSecret = '你的 App Secret';

$client = new Client($appId, $appSecret);
```

### 2. 获取 Access Token

使用 `getAccessToken` 方法来获取 `access_token`。

```php
try {
    $accessToken = $client->getAccessToken();
    echo 'Access Token: ' . $accessToken;
} catch (Exception $e) {
    echo '获取 Access Token 失败: ' . $e->getMessage();
}
```
**注意:** `getAccessToken` 方法中的接口地址是基于通用实践的假设，请根据小红书的官方文档进行核对和修改。

### 3. 生成签名

使用 `generateSign` 方法来为你的 API 请求参数生成签名。

```php
$params = [
    'param1' => 'value1',
    'param2' => 'value2',
    'timestamp' => time(),
    // ... 其他业务参数
];

$signature = $client->generateSign($params);

echo '生成的签名: ' . $signature;

// 你可以将签名添加到请求参数中
$params['sign'] = $signature;

// 然后使用这些参数发起 API 请求...
```

**签名算法说明:**
签名算法是基于通用实践编写的，具体步骤如下：
1.  移除参数中的 `sign` 字段。
2.  将所有非空参数的键名按照字典序升序排列。
3.  将排序后的参数以 `key=value` 的形式用 `&` 连接起来。
4.  在得到的字符串末尾拼接上 `app_secret`。
5.  使用 `HMAC-SHA256` 算法和 `app_secret` 作为密钥计算哈希值。

**重要提示:** 请务必对照小红书官方的开发文档，核对签名算法的详细规则（例如是否所有参数都参与签名、key 和 value 是否需要 URL 编码、空值如何处理等），并对 `generateSign` 方法进行相应的调整。 