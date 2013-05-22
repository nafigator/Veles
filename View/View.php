<?php
/**
 * Output class
 * @file    View.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 07 07:30:30 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View;

use \Veles\Routing\Route;
use \Exception;
use \Veles\View\Drivers\iViewDriver;

/**
 * Class View
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class View
{
    /**
     * Get driver instance
     * @return iViewDriver
     */
    private static function getDriver()
    {
        /**
         * @var iViewDriver
         */
        static $driver;

        if (null === $driver) {
            $driver = ViewFactory::build();
        }

        return $driver;
    }

    /**
     * Method for output variables setup
     *
     * @param array $vars Output variables array
     */
    final public static function set($vars)
    {
        self::getDriver()->set($vars);
    }

    /**
     * Output variables cleanup
     *
     * @param array $vars Variables array for cleanup
     */
    final public static function del($vars)
    {
        self::getDriver()->del($vars);
    }

    /**
     * Output method
     *
     * @param string $path Path to template
     */
    final public static function show($path)
    {
        self::getDriver()->show($path);
    }

    /**
     * Output View into buffer and save it in variable
     *
     * @param string $path Path to template
     * @return string View content
     */
    final public static function get($path)
    {
        return self::getDriver()->get($path);
    }
}
