<?php

namespace AmberSdk\Client;


use AmberSdk\Client\Model\ExecutionQuery;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class AppClient
{
    const HTTP_OK = 200;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var AuthManager
     */
    private $authManager;

    public function __construct($endpoint, AuthManager $authManager)
    {
        $this->authManager = $authManager;

        $this->httpClient = new Client([
            'base_uri' => $endpoint,
            'http_errors' => false
        ]);
    }

    /**
     * @param string $name Код (тип) объекта
     * @param int $id ИД экземпляра объекта
     * @return mixed Объект указанного типа 
     */
    public function getObject($name, $id)
    {
        $uri = "instance/{$name}/{$id}";
        $request = new Request('GET', $uri);
        $dataArray = $this->handleRequest($request);

        return $dataArray[0];
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     *
     * @throws Exception
     */
    private function handleRequest($request)
    {
        $token = $this->authManager->getToken();
        $request = $request->withHeader('Token', $token);
        $res = $this->httpClient->send($request);
        $statusCode = $res->getStatusCode();

        if ($statusCode === self::HTTP_OK) {
            $items = $this->getContent($res);

            return $items;
        } else {
            $content = $res->getBody()->getContents();
            if ($this->isAuthProblem($content)) {
                $token = $this->authManager->getToken(true);
                $request = $request->withHeader('Token', $token);
                $res = $this->httpClient->send($request);

                $statusCode = $res->getStatusCode();
                if ($statusCode === self::HTTP_OK) {
                    $items = $this->getContent($res);

                    return $items;
                }
            }
            throw new Exception($content);
        }
    }

    /**
     * @param $response
     * @return mixed
     */
    private function getContent(Response $response)
    {
        $data = $response->getBody()->getContents();
        if (substr($data, 0, 3) == pack("CCC", 0xEF, 0xBB, 0xBF)) {
            $data = substr($data, 3);
        }

        return json_decode($data);
    }

    /**
     * @param string $contents
     * @return bool
     */
    private function isAuthProblem($contents)
    {
        try {
            $response = simplexml_load_string($contents);
            return !empty($response->Detail->NotAuthorized);
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param string $name Код (тип) объекта
     * @param array $filter Ассоциативный массив пар 'Поле' => 'Значение' 
     * @param null $size - размер 
     * @param null $page - начальная страница
     * @return array Массив экземпляров указанного типа, подходящие под фильтр. Внимание, несколько условий объединяются через ИЛИ
     */
    public function getObjects($name, $filter = [], $size = null, $page = null)
    {
        $query = $this->prepareQueryOptions($filter, $size, $page);
        $uri = "instances/{$name}?{$query}";
        $request = new Request('GET', $uri);

        return $this->handleRequest($request);
    }

    /**
     * @param $filter
     * @param $size
     * @param $page
     * @return array
     */
    private function prepareQueryOptions($filter, $size, $page)
    {
        $query = [];
        if (!empty($size)) {
            $query['size'] = $size;
        }

        if (!empty($page)) {
            $query['page'] = $page;
        }

        if (!empty($filter)) {
            $conditions = json_encode(array_map(function ($k, $v) {
                return ['Left' => $k, 'Right' => $v, 'Operator' => 'Equal'];
            }, array_keys($filter), $filter));
            $query['conditions'] = $conditions;
        }

        return http_build_query($query);
    }

    /**
     * @param string $name Код (тип) объекта
     * @param array $data Ассоциативный массив пар 'Поле' => 'Значение', указанные значения будут присвоены полям нового экземпляра
     * @return int ИД вновь созданного экземпляра
     */
    public function saveObject($name, array $data)
    {
        $uri = "instance/{$name}";
        $request = new Request('POST', $uri, [], json_encode($data));
        $content = $this->handleRequest($request);

        return $content->InstanceId;
    }

    /**
     * @param string $name
     * @param int $id ИД экземпляра
     * @param array $data Ассоциативный массив пар 'Поле' => 'Значение', указанные поля будут обновлены.
     */
    public function updateObject($name, $id, array $data)
    {
        $uri = "instance/{$name}/{$id}";
        $request = new Request('PUT', $uri, [], json_encode($data));
        $this->handleRequest($request);
    }

    /**
     * @param ExecutionQuery $query
     * @return array
     */
    public function execQuery(ExecutionQuery $query)
    {
        $uri = "executeQuery";
        $request = new Request('POST', $uri, ["Content-Type" => "application/json"], json_encode($query));

        return $this->handleRequest($request);
    }
}
