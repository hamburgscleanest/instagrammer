<?php

namespace hamburgscleanest\Instagrammer\Exceptions;

/**
 * Class TooManyHashtags
 * @package hamburgscleanest\GuzzleAdvancedThrottle\Exceptions
 */
class TooManyHashtags extends \RuntimeException
{

    /**
     * TooManyHashtags constructor.
     * @param int $maxCount
     */
    public function __construct(int $maxCount)
    {
        parent::__construct('The comment must not contain more than ' . $maxCount . ' hashtags.');
    }
}
