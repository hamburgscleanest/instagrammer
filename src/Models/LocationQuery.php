<?php

namespace hamburgscleanest\Instagrammer\Models;

/**
 * Class LocationQuery
 * @package hamburgscleanest\Instagrammer\Models
 */
class LocationQuery
{

    /** @var ApiClient */
    private $_apiClient;

    /**
     * LocationQuery constructor.
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
        return $this->_apiClient->query('locations/' . $url, $method, $params);
    }

    /**
     * @param string $id
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $id)
    {
        return $this->_query($id);
    }

    /**
     * @param string $id
     * @param float|null $minTimestamp
     * @param float|null $maxTimestamp
     * @param string|null $minId
     * @param string|null $maxId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function recentMedia(string $id, float $minTimestamp = null, float $maxTimestamp = null, string $minId = null, string $maxId = null)
    {
        return $this->_query(
            $id . '/media/recent',
            [
                'min_timestamp' => $minTimestamp,
                'max_timestamp' => $maxTimestamp,
                'min_id'        => $minId,
                'max_id'        => $maxId,
            ]
        );

    }


    /**
     * @param Location $location
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(Location $location)
    {
        return $this->_query('search', $location->asParams());
    }

    /**
     * @param string $placeId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function facebook(string $placeId)
    {
        return $this->_query('search', ['facebook_places_id' => $placeId]);
    }

    /**
     * @param string $foursquareId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function foursquare(string $foursquareId)
    {
        return $this->_query('search', ['foursquare_v2_id' => $foursquareId]);
    }
}
