<?php

namespace AmberSdk\Client;


use Exception;
use Gregwar\Cache\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;


class AuthManager
{
    const TOKEN_CACHE_KEY = "TokenCacheKey";

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $lock;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $username;


    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->username = $config['user'];
        $this->password = $config['userPassword'];
        $this->lock = $config['lock_path'];
        $endpoint = $config['base_uri'] . $config['endpoint'];


        $this->httpClient = new Client([
            'base_uri' => $endpoint
        ]);

        $this->token = '';

        $this->cache = new Cache();
        $this->cache->setCacheDirectory($config['cacheDirectory']);
    }

    /**
     * @param bool $forceUpdate
     * @return string
     */
    public function getToken($forceUpdate = false)
    {
        if ($forceUpdate) {
            $this->token = "";
            $this->cache->set(self::TOKEN_CACHE_KEY, "");
        }

        if (empty($this->token)) {
            $cachedToken = $this->getTokenFromCache();
            if (!empty($cachedToken)) {
                $this->token = $cachedToken;
            } else {

                $fp = fopen($this->lock, "w+");
                flock($fp, LOCK_EX);

                $cachedToken = $this->getTokenFromCache();
                if (!empty($cachedToken)) {
                    $this->token = $cachedToken;
                } else {
                    $token = $this->getAuthTokenRemote();
                    $this->token = $token;
                    $this->cache->set(self::TOKEN_CACHE_KEY, $token);
                }
                fclose($fp);
            }
        }
        return $this->token;
    }

    /**
     * @return string
     *
     */
    private function getTokenFromCache()
    {
        if ($this->cache->exists(self::TOKEN_CACHE_KEY)) {
            return $this->cache->get(self::TOKEN_CACHE_KEY);
        }
        return "";
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    private function getAuthTokenRemote()
    {
        try {
            $options = ['json' => [
                'Login' => $this->username,
                'Password' => $this->password,
                'AppId' => '1'
            ]];
            $uri = 'auth';
            $res = $this->httpClient->post($uri, $options);

            $response = json_decode($res->getBody()->getContents());
            return $response->Token;
        } catch (ServerException $ex) {
            throw new Exception("Authentication error");
        }

    }

}