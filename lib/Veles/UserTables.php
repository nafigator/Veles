<?php
/**
 * Класс управления инфраструктурой данных для класса User
 * @file    UserTables.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Чтв Мар 08 18:58:09 2012
 * @version
 */

namespace Veles;

/**
 * Класс управления инфраструктурой данных для класса User
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
final class UserTables {
    /**
     * Метод для создания инфраструктуры данных для пользователя
     * @return  bool В случае отсутствия ошибок возвращает TRUE
     */
    final public function create()
    {
        $sql = '
            CREATE TABLE `' . User::TBL_USER . '` (
                `id`            int unsigned NOT NULL AUTO_INCREMENT,
                `email`         char(48) NOT NULL,
                `hash`          char(60) NOT NULL,
                `group`         tinyint unsigned NOT NULL DEFAULT "4",
                `last_login`    timestamp NOT NULL DEFAULT "0000-00-00 00:00:00",
                PRIMARY KEY (`id`),
                UNIQUE KEY (`email`),
                KEY `group` (`group`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ';

        Db::q($sql);

        $sql = '
            CREATE TABLE `' . User::TBL_USER_INFO . '` (
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
                FOREIGN KEY (`id`) REFERENCES `' . User::TBL_USER . '` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ';

        Db::q($sql);
    }

    /**
     * Метод очистки данных sql-таблиц для класса User
     */
    final public function cleanup()
    {
        Db::q('TRUNCATE TABLE `' . User::TBL_USER . '`');
        Db::q('TRUNCATE TABLE `' . User::TBL_USER_INFO . '`');
    }

    /**
     * Метод удаления sql-таблиц для класса User
     */
    final public function drop()
    {
        $sql = '
            DROP TABLE IF EXISTS
                `' . User::TBL_USER_INFO . '`,
                `' . User::TBL_USER . '`
        ';

        Db::q($sql);
    }
}
