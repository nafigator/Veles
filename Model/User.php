<?php
/**
 * Модель пользователя
 * @file    User.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Пнд Мар 05 21:39:43 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Model;

use \Veles\Auth\UsrGroup;
use \Veles\DataBase\Db;

/**
 * Модель пользователя
 */
class User extends AbstractModel
{
    const TBL_NAME      = 'users';
    const TBL_USER_INFO = 'users_info';

    protected static $map = array(
        'id'         => 'int',
        'email'      => 'string',
        'hash'       => 'string',
        'group'      => 'int',
        'last_login' => 'string'
    );

    /**
     * Метод для получения ID пользователя
     * @return int|bool
     */
    final public function getId()
    {
        return isset($this->id) ? $this->id : false;
    }

    /**
     * Метод для получения хэша пользователя, взятого из базы
     * @return string|bool
     */
    final public function getHash()
    {
        return isset($this->hash) ? $this->hash : false;
    }

    /**
     * Метод для получения хэша для кук
     * @return string|bool
     */
    final public function getCookieHash()
    {
        return isset($this->hash) ? substr($this->hash, 29) : false;
    }

    /**
     * Метод для получения соли хэша
     * @return string|bool
     */
    final public function getSalt()
    {
        return isset($this->hash) ? substr($this->hash, 0, 28) : false;
    }

    /**
     * Метод для получения группы пользователя
     * @return int
     */
    final public function getGroup()
    {
        return isset($this->group) ? $this->group : UsrGroup::GUEST;
    }
}
