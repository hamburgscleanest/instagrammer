<?php

namespace hamburgscleanest\Instagrammer\Models;

use GuzzleHttp\Client;
use hamburgscleanest\GuzzleAdvancedThrottle\RequestLimitRuleset;
use hamburgscleanest\LaravelGuzzleThrottle\Helpers\ClientHelper;
use hamburgscleanest\LaravelGuzzleThrottle\Helpers\ConfigHelper;
use Illuminate\Config\Repository;

/**
 * Class ApiClient
 * @package hamburgscleanest\Instagrammer\Models
 */
class ApiClient
{

    private const INSTAGRAM_API_URL = 'https://api.instagram.com/v1/';

    /** @var Client */
    private $_client;

    /** @var string */
    private $_accessToken;

    /**
     * ApiClient constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = \config('instagrammer');
        $cacheConfig = $config['cache'];

        $this->_accessToken = $config['access_token'];

        /**
         * https://developers.facebook.com/docs/instagram-api/overview/#rate-limiting
         */
        $this->_client = ClientHelper::getThrottledClient(
            ['base_uri' => self::INSTAGRAM_API_URL],
            new RequestLimitRuleset(
                [
                    self::INSTAGRAM_API_URL . '/media/comments' => [
                        [
                            'max_requests'     => 60,
                            'request_interval' => 3600
                        ]
                    ],
                    self::INSTAGRAM_API_URL                     => [
                        [
                            'max_requests'     => 200,
                            'request_interval' => 3600
                        ]
                    ]
                ],
                $cacheConfig['strategy'],
                'laravel',
                new Repository(ConfigHelper::getMiddlewareConfig($cacheConfig['driver'], $cacheConfig['ttl']))
            )
        );
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $params
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function query(string $url, string $method = 'get', array $params = [])
    {
        $response = (string) $this->_client->request($method, $url, ['query' => ['access_token' => $this->_accessToken] + $params])->getBody();
        if (empty($response))
        {
            return null;
        }

        $object = \GuzzleHttp\json_decode($response);

        return \property_exists($object, 'data') ? $object->data : $object;
    }

    /**
     * @param string $url
     * @param array $params
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $url, array $params = [])
    {
        return $this->query($url, 'get', $params);
    }

    /**
     * @param string $url
     * @param array $params
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $url, array $params = [])
    {
        return $this->query($url, 'post', $params);
    }
}
