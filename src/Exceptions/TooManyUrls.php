<?php

namespace hamburgscleanest\Instagrammer\Exceptions;

/**
 * Class TooManyUrls
 * @package hamburgscleanest\GuzzleAdvancedThrottle\Exceptions
 */
class TooManyUrls extends \RuntimeException
{

    /**
     * TooManyUrls constructor.
     * @param int $maxCount
     */
    public function __construct(int $maxCount)
    {
        parent::__construct('The comment must not contain more than ' . $maxCount . ' URLs.');
    }
}
