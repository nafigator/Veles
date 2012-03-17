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
    const TBL_BRUTFORCE = 'brutforce';
    const TBL_IP_BANNED = 'banned_ip';

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
                `id`            INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `email`         CHAR(48) NOT NULL,
                `hash`          CHAR(48) NOT NULL,
                `salt`          CHAR(22) NOT NULL,
                `group`         TINYINT(4) UNSIGNED NOT NULL DEFAULT "8",
                `last_login`    TIMESTAMP NOT NULL DEFAULT "0000-00-00 00:00:00",
                PRIMARY KEY (`id`),
                UNIQUE KEY (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ';

        Db::q($sql);

        $sql = '
            CREATE TABLE `' . self::TBL_USER_INFO . '` (
                `id`            INT(10) UNSIGNED NOT NULL,
                `first_name`    VARCHAR(30) NOT NULL,
                `middle_name`   VARCHAR(30) NOT NULL,
                `last_name`     VARCHAR(30) NOT NULL,
                `short_name`    VARCHAR(30) NOT NULL,
                `about`         VARCHAR(255) NOT NULL,
                `birth_date`    DATE NOT NULL,
                `icq`           VARCHAR(30) NOT NULL,
                `skype`         VARCHAR(30) NOT NULL,
                `created`       TIMESTAMP NOT NULL DEFAULT "0000-00-00 00:00:00",
                `updated`       TIMESTAMP NOT NULL DEFAULT "0000-00-00 00:00:00"
                    ON UPDATE CURRENT_TIMESTAMP,
                `active`        BIT(1) NOT NULL DEFAULT b\'0\',
                `act_key`       CHAR(48),
                FOREIGN KEY (`id`) REFERENCES `' . self::TBL_USER . '` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ';

        Db::q($sql);

        $sql = '
            CREATE TABLE `' . self::TBL_BRUTFORCE . '` (
                `id`            INT(10) UNSIGNED NOT NULL,
                `ip`            INT(10) UNSIGNED NOT NULL,
                `attempts`      TINYINT(1) UNSIGNED NOT NULL,
                `first_attempt` TIMESTAMP NOT NULL DEFAULT "0000-00-00 00:00:00",
                FOREIGN KEY (`id`) REFERENCES `' . self::TBL_USER . '` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ';

        Db::q($sql);

        //TODO: Сделать функцию mysql, которая бы периодически проверяла таблицу
        // на наличие записей, которые необходимо разбанить и удаляла эти записи??
        $sql = '
            CREATE TABLE `' . self::TBL_IP_BANNED . '` (
                `id`            INT(10) UNSIGNED NOT NULL,
                `ip`            INT(10) UNSIGNED NOT NULL,
                `unban_time`    TIMESTAMP NOT NULL DEFAULT "0000-00-00 00:00:00",
                FOREIGN KEY (`id`) REFERENCES `' . self::TBL_USER . '` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE,
                KEY (`unban_time`)
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
        Db::q('TRUNCATE TABLE `' . self::TBL_BRUTFORCE . '`');
        Db::q('TRUNCATE TABLE `' . self::TBL_IP_BANNED . '`');
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
                `' . self::TBL_BRUTFORCE . '`,
                `' . self::TBL_IP_BANNED . '`,
                `' . self::TBL_USER . '`
        ';

        Db::q($sql);
    }
}
