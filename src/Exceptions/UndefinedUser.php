<?php

namespace hamburgscleanest\Instagrammer\Exceptions;

/**
 * Class UndefinedUser
 * @package hamburgscleanest\GuzzleAdvancedThrottle\Exceptions
 */
class UndefinedUser extends \RuntimeException
{

    /**
     * UndefinedUser constructor.
     */
    public function __construct()
    {
        parent::__construct('Please provide a valid user id.');
    }
}
