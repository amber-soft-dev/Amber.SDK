# О проекте
Это обертка к REST API.
# Установка
Рекомендуемый способ - использование composer.
`composer require amber-soft/php.sdk`
# Использование
```
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
```

Основные методы AppClient:

```
getObject($name, $id)
```
 - Получение массива объектов по расширенному запросу
```
getObjects($name, $filter = [], $size = null, $page = null)
```
```
saveObject($name, array $data)
```
```
updateObject($name, $id, array $data)
```
```
execQuery(ExecutionQuery $query)
```
Получение массива объектов по расширенному запросу





