<?php

namespace hamburgscleanest\Instagrammer\Models;

/**
 * Class MediaQuery
 * @package hamburgscleanest\Instagrammer\Models
 */
class MediaQuery
{

    /**
     * @param string $url
     * @param array $params
     * @param string $method
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    private function _query(string $url, array $params = [], string $method = 'get')
    {
        return ApiClient::create()->query('media/' . $url, $method, $params);
    }

    /**
     * @param string $shortcode
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function shortcode(string $shortcode)
    {
        return ApiClient::create(null)->query('/oembed', 'get', ['url' => 'http://instagr.am/p/' . $shortcode]);
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
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function popular()
    {
        return $this->_query('popular');
    }

    /**
     * @param Location|null $location
     * @param int|null $minTimestamp
     * @param int|null $maxTimestamp
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(?Location $location = null, ?int $minTimestamp = null, ?int $maxTimestamp = null)
    {
        return $this->_query(
            'search',
            [
                'min_timestamp' => $minTimestamp,
                'max_timestamp' => $maxTimestamp
            ] + ($location !== null ? $location->asParams() : [])
        );
    }

    /**
     * @param string $mediaId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function comments(string $mediaId)
    {
        return $this->_query($mediaId . '/comments');
    }

    /**
     * @param string $mediaId
     * @param string $text
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function comment(string $mediaId, string $text)
    {
        CommentValidator::validate($text);

        return $this->_query($mediaId . '/comments', ['text' => $text], 'post');
    }

    /**
     * @param string $mediaId
     * @param string $commentId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeComment(string $mediaId, string $commentId)
    {
        return $this->_query($mediaId . '/comments/' . $commentId, [], 'delete');
    }

    /**
     * @param string $mediaId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function likes(string $mediaId)
    {
        return $this->_query($mediaId . '/likes');
    }

    /**
     * @param string $mediaId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function like(string $mediaId)
    {
        return $this->_query($mediaId . '/likes', [], 'post');
    }

    /**
     * @param string $mediaId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unlike(string $mediaId)
    {
        return $this->_query($mediaId . '/likes', [], 'delete');
    }
}
