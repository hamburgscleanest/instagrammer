<?php

namespace hamburgscleanest\Instagrammer\Exceptions;

/**
 * Class UnknownAction
 * @package hamburgscleanest\GuzzleAdvancedThrottle\Exceptions
 */
class UnknownAction extends \RuntimeException
{

    /**
     * UnknownAction constructor.
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct('Unknown action: ' . $action);
    }
}
