<?php

namespace hamburgscleanest\Instagrammer\Exceptions;

/**
 * Class CommentTooLong
 * @package hamburgscleanest\GuzzleAdvancedThrottle\Exceptions
 */
class CommentTooLong extends \RuntimeException
{

    /**
     * CommentTooLong constructor.
     * @param int $maxLength
     */
    public function __construct(int $maxLength)
    {
        parent::__construct('The text must not exceed ' . $maxLength . ' characters.');
    }
}
