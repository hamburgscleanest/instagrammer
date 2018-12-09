<?php

namespace hamburgscleanest\Instagrammer\Exceptions;

/**
 * Class AllCapitalNotAllowed
 * @package hamburgscleanest\GuzzleAdvancedThrottle\Exceptions
 */
class AllCapitalNotAllowed extends \RuntimeException
{

    /**
     * AllCapitalNotAllowed constructor.
     */
    public function __construct()
    {
        parent::__construct('The text must not contain only capital letters.');
    }
}
