<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Cache\Bridge;

use Webiny\Component\Cache\Cache;
use Webiny\Component\StdLib\ValidatorTrait;

/**
 * APC cache bridge loader.
 *
 * @package         Webiny\Component\Cache\Bridge
 */
class APC extends CacheAbstract
{

    /**
     * Path to the default bridge library for APC.
     *
     * @var string
     */
    private static $_library = '\Webiny\Component\Cache\Bridge\Memory\APC';

    /**
     * Get the name of bridge library which will be used as the driver.
     *
     * @return string
     */
    static function _getLibrary()
    {
        return Cache::getConfig()->get('Bridges.Apc', self::$_library);
    }

    /**
     * Change the default library used for the driver.
     *
     * @param string $pathToClass Path to the new driver class. Must be an instance of \Webiny\Component\Cache\Bridge\CacheInterface
     */
    static function setLibrary($pathToClass)
    {
        self::$_library = $pathToClass;
    }

}