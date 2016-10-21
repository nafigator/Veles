<?php
/**
 * Trait for handling version set and get methods
 *
 * @file      VersionTrait.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault dot info>
 * @date      2016-01-15 18:46
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Application;

trait VersionTrait
{
    /** @var  string */
    protected $version;

    /**
     * Get application version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set application version
     *
     * @param string $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }
}
