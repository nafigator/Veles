<?php
/**
 * @file    User.php
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
    const ADMIN      = 1;
    const MODERATOR  = 2;
    const REGISTERED = 4;
    const GUEST      = 8;
    const DELETED    = 16;

    // Свойства пользователя
    private $props = array();

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
            if (($this->props['group'] & $group) === $group)
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
                `email`, `hash`, `group`, `last_login`
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
     * @param   array $params id либо email пользователя
     * @return  bool
     */
    final public function getActive($params)
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
                `' . self::TBL_USER . '`
            WHERE
                ' . $where . '
            LIMIT 1
        ';


        $this->props = Db::q($sql);

        return $this->props;
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
            if (isset($this->props[$property_name])) {
                $properties[$property_name] = $this->props[$property_name];
            }
        }
    }

    /**
     * @fn    getId
     * @brief Метод для получения ID пользователя
     */
    final public function getId()
    {
        return (isset($this->props['id'])) ? $this->props['id'] : FALSE;
    }

    /**
     * @fn    getHash
     * @brief Метод для получения хэша пользователя, взятого из базы
     */
    final public function getHash()
    {
        return (isset($this->props['hash'])) ? $this->props['hash'] : FALSE;
    }

    /**
     * @fn    getCookieHash
     * @brief Метод для получения хэша для кук
     */
    final public function getCookieHash()
    {
        return (isset($this->props['hash'])) ? substr($this->props['hash'], 29) : FALSE;
    }

    /**
     * @fn    getSalt
     * @brief Метод для получения соли хэша
     */
    final public function getSalt()
    {
        return (isset($this->props['hash'])) ? substr($this->props['hash'], 0, 28) : FALSE;
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
            $this->props[$property_name] = $properties[$property_name];
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
