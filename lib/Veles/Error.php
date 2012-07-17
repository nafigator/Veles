<?php
/**
 * Обработка исключений
 * @file    Error.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Пнд Июл 16 22:08:47 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles;

use \SplSubject,
    \SplObserver;

/**
 * Класс Error
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Error implements SplSubject
{
    private static $error     = null;
    private static $observers = array();

    /**
     * Метод обработки исключений
     * @param Exception $e
     */
    final public static function init($e)
    {
        if ('development' === ENVIRONMENT) {
            $error = isset($e->xdebug_message)
                ? '<table>' . $e->xdebug_message . '</table>'
                : '<pre>'   . $e->__toString()   . '</pre>';

            $variables = array(
                'title' => $e->getMessage(),
                'error' => $error
            );

            View::set($variables);
            View::show('error', 'exception');
        }
        else {
            self::$error = new Error;
            //TODO: Запись в лог? Уведомление на email? SMS?
            self::$error->notify();
        }
    }

    /**
     * Метод уведомления наблюдателей об ошибке
     */
    final public function notify()
    {
        echo 'Уведомление наблюдателей';
    }

    /**
     * Метод добавления наблюдателей
     */
    final public function attach(SplObserver $observer)
    {
        echo 'Добавление наблюдателей';
    }

    /**
     * Метод удаления наблюдателей
     */
    final public function detach(SplObserver $observer)
    {
        echo 'Удаление наблюдателей';
    }
}
