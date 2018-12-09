<?php

namespace hamburgscleanest\Instagrammer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Instagrammer
 * @package hamburgscleanest\Instagrammer\Facades
 *
 */
class Instagrammer extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() : string { return 'instagrammer'; }
}
