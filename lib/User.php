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
    // Группы пользователя
    const USR_ADMIN      = 1;
    const USR_MODERATOR  = 2;
    const USR_REGISTERED = 4;
    const USR_GUEST      = 8;

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
        switch (true) {
            // Пользователь авторизуеся через ajax-форму
            case (isset($_GET['ln']) && isset($_GET['ps'])) :
                Auth::byAjax();
                break;
            // Пользователь уже авторизовался ранее
            case (isset($_COOKIE['id']) && isset($_COOKIE['ps'])) :
                Auth::byCookie();
                break;
            default:
                $this->props = array('group' => self::USR_GUEST);
        }
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
    final public static function save(&$data)
    {
        $sql = '
            INSERT `user`
                `email`, `hash`, `salt`, `group`, `last_login`
            FROM
                `user`
            WHERE
                `id` = ' . $_COOKIE['id'] . '
            LIMIT 1
        ';
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
            if (isset($this->prop[$property_name])) {
                $properties[$property_name] = $this->prop[$property_name];
            }
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
