<?php

namespace hamburgscleanest\Instagrammer\Exceptions;

/**
 * Class DistanceOutOfBounds
 * @package hamburgscleanest\GuzzleAdvancedThrottle\Exceptions
 */
class DistanceOutOfBounds extends \RuntimeException
{

    /**
     * DistanceOutOfBounds constructor.
     * @param int $maxDistance
     */
    public function __construct(int $maxDistance)
    {
        parent::__construct('The distance must not be greater than ' . $maxDistance . ' meters.');
    }
}
