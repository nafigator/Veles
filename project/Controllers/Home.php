<?php
/**
 * Контроллер главной страницы
 * @file    Home.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 07 07:24:06 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Controllers;

use \Veles\CurrentUser,
    \Forms\LoginForm;

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
        $return['title']  = 'Главная страница!';
        $return['text']   = 'Veles - PHP micro-framework';
        $return['status'] = '';

        $form = new LoginForm;
        if ($form->submitted()) {
            $return['status'] = 'Form submitted!<br/>';

            if ($form->valid())
                $return['status'] .= 'Form valid!<br/>';
        }

        $return['form'] = $form;

        return $return;
    }
}
