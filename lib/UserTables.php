<?php
/**
 * @file    UserTables.class.inc
 * @brief   Класс управления инфраструктурой данных для класса User
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Чтв Мар 08 18:58:09 2012
 * @version
 */

// Не допускаем обращения к файлу напрямую
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) exit();

/**
 * @class   UserTables
 * @brief   Класс управления инфраструктурой данных для класса User
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
final class UserTables {
    const TBL_USER      = 'user';
    const TBL_USER_INFO = 'user_info';

    /**
     * @fn      create
     * @brief   Метод для создания инфраструктуры данных для пользователя
     *
     * @return  bool В случае отсутствия ошибок возвращает TRUE
     */
    public function create()
    {
        $sql = '
            CREATE TABLE `' . self::TBL_USER . '` (
                `id`            int unsigned NOT NULL AUTO_INCREMENT,
                `email`         char(48) NOT NULL,
                `hash`          char(48) NOT NULL,
                `salt`          char(22) NOT NULL,
                `group`         tinyint unsigned NOT NULL DEFAULT "4",
                `last_login`    timestamp NOT NULL DEFAULT "0000-00-00 00:00:00",
                PRIMARY KEY (`id`),
                UNIQUE KEY (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ';

        Db::q($sql);

        $sql = '
            CREATE TABLE `' . self::TBL_USER_INFO . '` (
                `id`            int unsigned NOT NULL,
                `first_name`    varchar(30) NOT NULL,
                `middle_name`   varchar(30) NOT NULL,
                `last_name`     varchar(30) NOT NULL,
                `short_name`    varchar(30) NOT NULL,
                `about`         varchar(255) NOT NULL,
                `birth_date`    date NOT NULL,
                `icq`           varchar(30) NOT NULL,
                `skype`         varchar(30) NOT NULL,
                `created`       timestamp NOT NULL DEFAULT "0000-00-00 00:00:00",
                `updated`       timestamp NOT NULL DEFAULT "0000-00-00 00:00:00"
                    ON UPDATE CURRENT_TIMESTAMP,
                `active`        tinyint(1) NOT NULL DEFAULT "0",
                `act_key`       char(48),
                FOREIGN KEY (`id`) REFERENCES `' . self::TBL_USER . '` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ';

        Db::q($sql);
    }

    /**
     * @fn      cleanup
     * @brief   Метод очистки данных sql-таблиц для класса User
     */
    public function cleanup()
    {
        Db::q('TRUNCATE TABLE `' . self::TBL_USER . '`');
        Db::q('TRUNCATE TABLE `' . self::TBL_USER_INFO . '`');
    }

    /**
     * @fn      drop
     * @brief   Метод удаления sql-таблиц для класса User
     */
    public function drop()
    {
        $sql = '
            DROP TABLE IF EXISTS
                `' . self::TBL_USER_INFO . '`,
                `' . self::TBL_USER . '`
        ';

        Db::q($sql);
    }
}
