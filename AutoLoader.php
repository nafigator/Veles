<?php
/**
 * Class AutoLoader
 * @file    AutoLoader.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Fri Jun 01 10:19:04 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

/**
 * Class AutoLoader
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class AutoLoader
{
    /**
     * Initialisation
     */
    final public static function init()
    {
        spl_autoload_register(__NAMESPACE__ . '\AutoLoader::load');
    }

    /**
     * AutoLoader
     *
     * @param string $name
     */
    final public static function load($name)
    {
        $name = str_replace('\\', DIRECTORY_SEPARATOR, $name);

        // For using external libs with their own autoloaders
        // do not use strict require function
        include "$name.php";
    }
}
