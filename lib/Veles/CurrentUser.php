<?php
/**
 * Класс CurrentUser
 * @file    CurrentUser.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Пнд Мар 05 21:39:43 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles;

use \Veles\Model\AbstractModel,
    \Veles\DataBase\Db;

/**
 * Модель пользователя
 */
class CurrentUser extends AbstractModel
{
    const TBL_NAME      = 'users';
    const TBL_USER_INFO = 'users_info';

    // Группы пользователя
    const ADMIN      = 1;
    const MANAGER    = 2;
    const MODERATOR  = 4;
    const REGISTERED = 8;
    const GUEST      = 16;
    const DELETED    = 32;

    private static $instance = null;
    private static $auth     = null;

    public static $map = array(
        'id'         => 'int',
        'email'      => 'string',
        'hash'       => 'string',
        'group'      => 'int',
        'last_login' => 'string'
    );

    public static $required_fields = array(
        'email'      => true,
        'hash'       => true
    );

    /**
     * Доступ к объекту текущего пользователя
     * @return  CurrentUser
     */
    final public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new CurrentUser;
            self::$auth     = new Auth(self::$instance);
        }

        return self::$instance;
    }

    /**
     * Доступ к авторизации пользователя
     */
    final public function getAuth()
    {
        return self::$auth;
    }

    /**
     * Метод для проверки состоит ли пользователь в определённых группах
     * @param   array
     * @return  bool
     */
    final public function hasAccess($groups)
    {
        // Проверяем есть ли в группах пользователя определённый бит,
        // соответствующий нужной группе.
        foreach ($groups as $group) {
            if ($group === ($this->group & $group))
                return true;
        }
    }

    /**
     * Метод для получения данных не удалённого пользователя
     * @param   array $params id либо email пользователя
     * @return  bool
     */
    final public function findActive($params)
    {
        $where = '';
        foreach ($params as $key => $value) {
            if (is_string($value))
                $value = "'$value'";

            $where .= "`$key` = $value && ";
        }

        $where .= '`group` & ' . self::DELETED . ' = 0';

        $sql = '
            SELECT
                `id`, `email`, `hash`, `group`, `last_login`
            FROM
                `' . $this::TBL_NAME . '`
            WHERE
                ' . $where . '
            LIMIT 1
        ';

        $result = Db::q($sql);

        if (!empty($result)) {
            foreach ($result as $name => $value) {
                $this->$name = $value;
            }
        }

        return $result;
    }

    /**
     * Метод для получения ID пользователя
     * @return int|bool
     */
    final public function getId()
    {
        return (isset($this->id)) ? $this->id : false;
    }

    /**
     * Метод для получения хэша пользователя, взятого из базы
     * @return string|bool
     */
    final public function getHash()
    {
        return (isset($this->hash)) ? $this->hash : false;
    }

    /**
     * Метод для получения хэша для кук
     * @return string|bool
     */
    final public function getCookieHash()
    {
        return (isset($this->hash)) ? substr($this->hash, 29) : false;
    }

    /**
     * Метод для получения соли хэша
     * @return string|bool
     */
    final public function getSalt()
    {
        return (isset($this->hash)) ? substr($this->hash, 0, 28) : false;
    }

    /**
     * Метод для удаления пользователя
     * @return  bool
     */
    final public function delete()
    {
        $this->group |= self::DELETED;
        return $this->save();
    }
}
