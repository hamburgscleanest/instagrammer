<?php


namespace hamburgscleanest\Instagrammer\Models;


use hamburgscleanest\Instagrammer\Exceptions\AllCapitalNotAllowed;
use hamburgscleanest\Instagrammer\Exceptions\CommentTooLong;
use hamburgscleanest\Instagrammer\Exceptions\TooManyHashtags;
use hamburgscleanest\Instagrammer\Exceptions\TooManyUrls;

/**
 * Class CommentValidator
 * @package hamburgscleanest\Instagrammer\Models
 */
class CommentValidator
{

    private const MAX_COMMENT_LENGTH = 300;
    private const MAX_HASHTAG_COUNT  = 4;
    private const MAX_URL_COUNT      = 1;

    /**
     * @param string $comment
     */
    public static function validate(string $comment) : void
    {
        if (\mb_strlen($comment) > self::MAX_COMMENT_LENGTH)
        {
            throw new CommentTooLong(self::MAX_COMMENT_LENGTH);
        }

        if (\substr_count($comment, '#') > self::MAX_HASHTAG_COUNT)
        {
            throw new TooManyHashtags(self::MAX_HASHTAG_COUNT);
        }

        if (\preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w]+\)|([^,[:punct:]\s]|/))#', $comment) > self::MAX_URL_COUNT)
        {
            throw new TooManyUrls(self::MAX_URL_COUNT);
        }

        if (\ctype_upper($comment))
        {
            throw new AllCapitalNotAllowed();
        }
    }

}
