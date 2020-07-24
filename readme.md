# О проекте
Это обертка к REST API.
# Установка
Рекомендуемый способ - использование composer.
```
composer require amber-soft-dev/php.sdk
```
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
Получение записи по идентификатору
```
getObjects($name, $filter = [], $size = null, $page = null)
```
Получение списка записей данных объекта с возможностью фильтрации и пейджинга

```
saveObject($name, array $data)
```
Позволяет создать записи данных для объекта 
```
updateObject($name, $id, array $data)
```
Позволяет редактировать записи данных для объекта
```
execQuery(ExecutionQuery $query)
```
Получение массива объектов по расширенному запросу





