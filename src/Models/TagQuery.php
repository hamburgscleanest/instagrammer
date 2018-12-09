<?php

namespace hamburgscleanest\Instagrammer\Models;

/**
 * Class TagQuery
 * @package hamburgscleanest\Instagrammer\Models
 */
class TagQuery
{

    /** @var ApiClient */
    private $_apiClient;

    /**
     * TagQuery constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->_apiClient = new ApiClient();
    }

    /**
     * @param string $url
     * @param array $params
     * @param string $method
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function _query(string $url, array $params = [], string $method = 'get')
    {
        return $this->_apiClient->query('tags/' . $url, $method, $params);
    }


    /**
     * @param string $name
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(string $name)
    {
        return $this->_query('search', ['q' => $name]);
    }

    /**
     * @param string $name
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $name)
    {
        return $this->_query($name);
    }

    /**
     * @param string $name
     * @param int $resultCount
     * @param string|null $minTagId
     * @param string|null $maxTagId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function recentMedia(string $name, int $resultCount = 15, string $minTagId = null, string $maxTagId = null)
    {
        return $this->_query($name . '/media/recent', ['count' => $resultCount, 'min_tag_id' => $minTagId, 'max_tag_id' => $maxTagId]);
    }
}
