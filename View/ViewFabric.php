<?php
/**
 * Class for create view driver
 *
 * @file    ViewFabric.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2013-05-18 07:40
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View;

use \Veles\View\Drivers\iViewDriver;
use \Veles\Config;

/**
 * Class ViewFabric
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class ViewFabric
{
    /**
     * Method for create view driver
     * @throws Exception
     * @return iViewDriver
     */
    final public static function getDriver()
    {
        if (null === ($class = Config::getParams('view_driver'))) {
            throw new Exception('Not found View driver parms in config!');
        }

        $class_name = "\\Veles\\View\\Drivers\\$class";

        $driver = new $class_name;

        if (!$driver instanceof iViewDriver) {
            throw new Exception('Not correct View driver!');
        }

        return new $driver;
    }
}
