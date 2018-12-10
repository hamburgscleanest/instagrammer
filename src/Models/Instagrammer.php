<?php

namespace hamburgscleanest\Instagrammer\Models;

/**
 * Class Instagrammer
 * @package hamburgscleanest\Instagrammer\Models
 */
class Instagrammer
{

    /**
     * @return UserQuery
     * @throws \Exception
     */
    public function users() : UserQuery
    {
        return new UserQuery();
    }

    /**
     * @return MediaQuery
     * @throws \Exception
     */
    public function media() : MediaQuery
    {
        return new MediaQuery();
    }

    /**
     * @return TagQuery
     * @throws \Exception
     */
    public function tags() : TagQuery
    {
        return new TagQuery();
    }

    /**
     * @return LocationQuery
     * @throws \Exception
     */
    public function locations() : LocationQuery
    {
        return new LocationQuery();
    }
}
