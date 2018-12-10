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

    private const INSTAGRAM_API_URL = 'https://api.instagram.com';
    private const BASE_RULES        = [
        'max_requests'     => 200,
        'request_interval' => 3600
    ];

    /** @var Client */
    private $_client;

    /** @var string */
    private $_accessToken;

    /**
     * @param int|null $version
     * @return string
     */
    private function _getVersionedApiUrl(?int $version = null) : string
    {
        if (!$version)
        {
            return self::INSTAGRAM_API_URL;
        }

        return self::INSTAGRAM_API_URL . '/v' . $version . '/';
    }

    /**
     * ApiClient constructor.
     * @param int $version
     * @throws \Exception
     */
    public function __construct(int $version = 1)
    {
        $config = \config('instagrammer');
        $cacheConfig = $config['cache'];

        $this->_accessToken = $config['access_token'];

        /**
         * https://developers.facebook.com/docs/instagram-api/overview/#rate-limiting
         */
        $this->_client = ClientHelper::getThrottledClient(
            ['base_uri' => $this->_getVersionedApiUrl($version)],
            new RequestLimitRuleset(
                [
                    $this->_getVersionedApiUrl($version) . '/media/comments' => [
                        [
                            'max_requests'     => 60,
                            'request_interval' => 3600
                        ]
                    ],
                    $this->_getVersionedApiUrl($version)                     => [self::BASE_RULES],
                    self::INSTAGRAM_API_URL                                  => [self::BASE_RULES]
                ],
                $cacheConfig['strategy'],
                'laravel',
                new Repository(ConfigHelper::getMiddlewareConfig($cacheConfig['driver'], $cacheConfig['ttl']))
            )
        );
    }

    /**
     * @param int $version
     * @return ApiClient
     * @throws \Exception
     */
    public static function create(int $version = 1) : self
    {
        return new ApiClient($version);
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
}
