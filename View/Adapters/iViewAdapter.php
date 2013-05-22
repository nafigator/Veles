<?php
/**
 * Interface for View adapters
 *
 * @file    iViewDriver.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2013-05-15 22:01
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View\Adapters;

use \Exception;

/**
 * Interface iViewAdapter
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
interface iViewAdapter
{
    /**
     * Method for output variables setup
     *
     * @param array $vars Output variables array
     * @throws Exception
     */
    public function set($vars);

    /**
     * Output variables cleanup
     *
     * @param array $vars Variables array for cleanup
     * @throws Exception
     */
    public function del($vars);

    /**
     * Output method
     *
     * @param string $path Path to template
     */
    public function show($path);

    /**
     * Output View into buffer and save it in variable
     *
     * @param string $path Path to template
     * @return string View content
     */
    public function get($path);
}
