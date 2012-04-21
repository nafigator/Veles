<?php
/**
 * @file    User.class.inc
 * @brief   Класс User
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Пнд Мар 05 21:39:43 2012
 * @version
 */

// Не допускаем обращения к файлу напрямую
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) exit();

/**
 * @class   User
 * @brief   Модель пользователя
 */
class User
{
    const TBL_USER      = 'users';
    const TBL_USER_INFO = 'users_info';

    // Группы пользователя
    const USR_ADMIN      = 1;
    const USR_MODERATOR  = 2;
    const USR_REGISTERED = 4;
    const USR_GUEST      = 8;

    // Свойства пользователя
    private $_props  = array();

    /**
     * @fn      auth
     * @brief   Метод для авторизации пользователя
     *
     * @return  bool
     */
    final public function auth()
    {
        $auth = new Auth($this);

        return $auth;
    }

    /**
     * @fn      hasAccess
     * @brief   Метод для проверки состоит ли пользователь в определённых группах
     * @param   array
     *
     * @return  bool
     */
    final public function hasAccess($groups)
    {
        $result = FALSE;
        // Проверяем есть ли в группах пользователя определённый бит,
        // соответствующий нужной группе.
        foreach ($groups as $group)
            if (($this->_props['group'] & $group) === $group)
                $result = TRUE;
        return $result;
    }

    /**
     * @fn      save
     * @brief   Метод для сохранения данных пользователя
     * @par     Best practicies:
     * Использовать AJAX + GET (POST требует дополнительного заголовка)\n
     * Поля формы называть следующим образом: name="user[firstname]". Получится
     * массив $_GET['user']['firstname'] и т.д.
     *
     * @param   array Массив, полученный из формы.
     * @return  bool
     */
    final public function save(&$data)
    {
        $sql = '
            INSERT `user`
                `email`, `hash`, `salt`, `group`, `last_login`
            FROM
                `' . self::TBL_USER . '`
            WHERE
                `id` = ' . $_COOKIE['id'] . '
            LIMIT 1
        ';
    }

     /**
     * @fn      getByParam
     * @brief   Метод для получения данных пользователя
     *
     * @param   array id либо email пользователя
     * @return  bool
     */
    final public function getByParam($param)
    {
        foreach ($param as $key => $value) {
            $sql = '
                SELECT
                    `id`, `email`, `hash`, `salt`, `group`, `last_login`
                FROM
                    `' . self::TBL_USER . '`
                WHERE
                    `' . $key . '` = "' . $value . '"
                LIMIT 1
            ';
        }

        $this->_props = Db::q($sql);

        return $this->_props;
    }

    /**
     * @fn      getProperties
     * @brief   Метод для получения параметров пользователя
     *
     * @param   array Массив с требуемыми параметрами в ключах массива
     * @return  array
     */
    final public function getProperties(&$properties)
    {
        foreach ($properties as $property_name => $value) {
            if (isset($this->_props[$property_name])) {
                $properties[$property_name] = $this->_props[$property_name];
            }
        }
    }

    /**
     * @fn      setProperties
     * @brief   Метод для получения параметров пользователя
     *
     * @param   array Массив с требуемыми параметрами в ключах массива
     * @return  array
     */
    final public function setProperties(&$properties)
    {
        foreach ($properties as $property_name => $value) {
            $this->_props[$property_name] = $properties[$property_name];
        }
    }

     /**
     * @fn      delete
     * @brief   Метод для удаления пользователя
     *
     * @param   int id пользователя
     * @return  bool
     */
    final public function delete(&$id)
    {

    }
}
