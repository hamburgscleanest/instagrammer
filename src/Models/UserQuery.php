<?php

namespace hamburgscleanest\Instagrammer\Models;

use hamburgscleanest\Instagrammer\Exceptions\UndefinedUser;
use hamburgscleanest\Instagrammer\Exceptions\UnknownAction;

/**
 * Class UserQuery
 * @package hamburgscleanest\Instagrammer\Models
 */
class UserQuery
{

    private const KNOWN_ACTIONS = [
        'follow',
        'unfollow',
        'block',
        'unblock',
        'approve',
        'ignore'
    ];

    /**
     * @param string $url
     * @param array $params
     * @param string $method
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    private function _query(string $url, array $params = [], string $method = 'get')
    {
        return ApiClient::create()->query('users/' . $url, $method, $params);
    }

    /**
     * @param string $query
     * @param int $resultCount
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(string $query, int $resultCount = 25)
    {
        return $this->_query('search', ['q' => $query, 'count' => $resultCount]);
    }

    /**
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function self()
    {
        return $this->find('self');
    }

    /**
     * @param string $userId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $userId)
    {
        return $this->_query($userId);
    }

    /**
     * @param string $userId
     * @param int $resultCount
     * @param array $additional Valid options: minTimestamp / maxTimestamp (unix timestamps), minMediaId / maxMediaId (string)
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function recent(string $userId = 'self', int $resultCount = 10, array $additional = [])
    {
        return $this->_query(
            $userId . '/media/recent',
            [
                'count'         => $resultCount,
                'max_timestamp' => + $additional['maxTimestamp'] ?? null,
                'min_timestamp' => + $additional['minTimestamp'] ?? null,
                'min_id'        => + $additional['minMediaId'] ?? null,
                'max_id'        => + $additional['maxMediaId'] ?? null,
            ]
        );
    }

    /**
     * @param int $resultCount
     * @param string|null $maxMediaId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function liked(int $resultCount = 50, ?string $maxMediaId = null)
    {
        return $this->_query('self/media/liked', ['count' => $resultCount, 'max_like_id' => $maxMediaId]);
    }

    /**
     * @param string $userId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function followers(string $userId = 'self')
    {
        return $this->_query($userId . '/followed-by');
    }

    /**
     * @param string $userId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function following(string $userId = 'self')
    {
        return $this->_query($userId . '/follows');
    }

    /**
     * @param string $userId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function relationTo(string $userId)
    {
        return $this->_query($userId . '/relationship');
    }

    /**
     * @param string $userId
     * @param string $action
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function action(string $userId, string $action)
    {
        if (!\in_array($action, self::KNOWN_ACTIONS, true))
        {
            throw new UnknownAction($action);
        }

        return $this->_query($userId . '/relationship', ['action' => $action], 'post');
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __call(string $name, array $arguments)
    {
        if (\count($arguments) === 0)
        {
            throw new UndefinedUser();
        }

        return $this->action($arguments[0] ?? 'undefined', $name);
    }
}
