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
 * @brief   Класс реализующий авторизацию и управление пользователями. Перед
 * авторизацией проверяется таблица
 */
class User
{
    const ERR_INVALID_EMAIL    = 1; // login
    const ERR_INVALID_PASSWORD = 2;
    const ERR_INVALID_ID       = 4;
    const ERR_INVALID_HASH     = 8;
    const ERR_USER_NOT_FOUND   = 16;
    const ERR_WRONG_PASSWORD   = 32;

    // Группы пользователя
    const USR_ADMIN      = 1;
    const USR_MODERATOR  = 2;
    const USR_REGISTERED = 4;
    const USR_GUEST      = 8;

    // Авторизационные свойства пользователя
    private $credentials = array();
    // Свойства пользователя
    private $props  = array();

    // В переменной будет содержаться побитная информация об ошибках
    private $_errors = 0;

    /**
     * @fn      __construct
     * @brief   Конструктор класса User
     * @details Авторизует пользователя по кукам. Если пользователь не авторизован,
     * создаётся экземпляр Guest.\n Если пользователь прислал GET-данные авторизации
     * через AJAX-форму, устанавливаем куки пользователю.
     */
    final public function __construct()
    {
        // Пользователь авторизуеся через ajax-форму
        if (isset($_GET['ln']) && isset($_GET['ps'])) {
            Auth::byAjax();
        }
        // Пользователь уже авторизовался ранее
        elseif (isset($_COOKIE['id']) && isset($_COOKIE['ps'])) {
            Auth::byCookie();
        }
        else
            $this->props = array('group' => self::USR_GUEST);
    }

    /**
     * @fn      hasCredentials
     * @brief   Метод для проверки состоит ли пользователь в определённых группах
     * @param   array
     *
     * @return  bool
     */
    final public function hasCredentials($groups)
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
    final public static function save(&$data)
    {

    }

     /**
     * @fn      getById
     * @brief   Метод для получения авторизационных данных пользователя
     *
     * @param   int id пользователя
     * @return  bool
     */
    final public static function getById()
    {
        $sql = '
            SELECT
                `id`, `email`, `hash`, `salt`, `group`, `last_login`
            FROM
                `user`
            WHERE
                `id` = ' . $_COOKIE['id'] . '
            LIMIT 1
        ';

        $this->$props = Db::q($sql)->fetch_all();

        if (empty($this->$props))
            return FALSE;

        return TRUE;
    }

     /**
     * @fn      getByEmail
     * @brief   Метод для получения авторизационных данных пользователя, если
     * пользователь авторизуется из формы
     *
     * @param   int id пользователя
     * @return  array
     */
    final public static function getByEmail(&$mail)
    {

    }

    /**
     * @fn      getByEmail
     * @brief   Метод для получения параметров пользователя
     *
     * @param   array Массив с требуемыми параметрами в ключах массива
     * @return  array
     */
    final public static function getProperties(&$properties)
    {
        foreach ($properties as $property_name => $value) {
            if (isset(self::$prop[$property_name]))
                $properties[$property_name] = self::$prop[$property_name];
        }
    }

     /**
     * @fn      delete
     * @brief   Метод для удаления пользователя
     *
     * @param   int id пользователя
     * @return  bool
     */
    final public static function delete(&$id)
    {

    }
}
