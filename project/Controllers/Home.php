<?php
/**
 * Контроллер главной страницы
 * @file    Home.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 07 07:24:06 2012
 * @version
 */

namespace Controllers;

use Veles\CurrentUser;

/**
 * Класс Home
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Home
{
    /**
     * Главная страница
     */
    final public function index()
    {
        $return['text'] = 'Главная страница!';
        $return['user'] = CurrentUser::instance();
        return $return;
    }
}
