<?php
/**
 * Класс CurrentUser
 * @file    CurrentUser.php
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Пнд Мар 05 21:39:43 2012
 * @version
 */

/**
 * Модель пользователя
 */
class CurrentUser extends AbstractModel
{
    const TBL_NAME      = 'users';
    const TBL_USER_INFO = 'users_info';

    // Группы пользователя
    const ADMIN      = 1;
    const MODERATOR  = 2;
    const REGISTERED = 4;
    const GUEST      = 8;
    const DELETED    = 16;

    /**
     * Метод для авторизации пользователя
     * @return  bool
     */
    final public function auth()
    {
        $auth = new Auth($this);

        return $auth;
    }

    /**
     * Метод для проверки состоит ли пользователь в определённых группах
     * @param   array
     * @return  bool
     */
    final public function hasAccess($groups)
    {
        $result = FALSE;
        // Проверяем есть ли в группах пользователя определённый бит,
        // соответствующий нужной группе.
        foreach ($groups as $group) {
            if (($this->group & $group) === $group) {
                $result = TRUE;
            }
        }

        return $result;
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
        return (isset($this->id)) ? $this->id : FALSE;
    }

    /**
     * Метод для получения хэша пользователя, взятого из базы
     * @return string|bool
     */
    final public function getHash()
    {
        return (isset($this->hash)) ? $this->hash : FALSE;
    }

    /**
     * Метод для получения хэша для кук
     * @return string|bool
     */
    final public function getCookieHash()
    {
        return (isset($this->hash)) ? substr($this->hash, 29) : FALSE;
    }

    /**
     * Метод для получения соли хэша
     * @return string|bool
     */
    final public function getSalt()
    {
        return (isset($this->hash)) ? substr($this->hash, 0, 28) : FALSE;
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
