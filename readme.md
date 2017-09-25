О проекте

Это обертка к REST API.

Установка

`composer require amber-soft/php.sdk`

Использование

$config = array(
    'base_uri'=> 'https://your-url.amber-saas.com/',
    'endpoint'=>'API/V1.svc/',
    'user'=>'User1',
    'userPassword' => 'userpass',
    'lock_path' => '/tmp/lock.txt',
    'cacheDirectory' => '/tmp/cache'
);

$endpoint = $config['base_uri'] . $config['endpoint'];
$client = new \AmberSdk\Client\AppClient($endpoint, new \AmberSdk\Client\AuthManager($config));


