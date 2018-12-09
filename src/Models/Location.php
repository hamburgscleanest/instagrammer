<?php


namespace hamburgscleanest\Instagrammer\Models;


use hamburgscleanest\Instagrammer\Exceptions\DistanceOutOfBounds;

/**
 * Class Location
 * @package hamburgscleanest\Instagrammer\Models
 */
class Location
{

    /** @var float */
    private $_latitude;
    /** @var float */
    private $_longitude;
    /** @var int */
    private $_distance;

    private const DEFAULT_DISTANCE = 1000;
    private const MAX_DISTANCE     = 5000;

    /**
     * Location constructor.
     * @param float $latitude
     * @param float $longitude
     * @param int $distance
     */
    public function __construct(float $latitude, float $longitude, int $distance = self::DEFAULT_DISTANCE)
    {
        if ($distance > self::MAX_DISTANCE)
        {
            throw new DistanceOutOfBounds(self::MAX_DISTANCE);
        }

        $this->_latitude = $latitude;
        $this->_longitude = $longitude;
        $this->_distance = $distance;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $distance
     * @return Location
     */
    public static function create(float $latitude, float $longitude, int $distance = self::DEFAULT_DISTANCE) : self
    {
        return new self($latitude, $longitude, $distance);
    }

    /**
     * @return array
     */
    public function asParams() : array
    {
        return [
            'lat'      => $this->_latitude,
            'lng'      => $this->_longitude,
            'distance' => $this->_distance
        ];
    }
}
