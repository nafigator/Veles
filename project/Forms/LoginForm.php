<?php
/**
 * Форма логина пользователя
 * @file    LoginForm.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 14 06:01:42 2012
 * @version
 */

namespace Forms;

use \Veles\Validators\RegEx,
    \Veles\Form\AbstractForm,
    \Veles\Form\Elements\TextElement,
    \Veles\Form\Elements\ButtonElement,
    \Veles\Form\Elements\PasswordElement;


/**
 * Класс LoginForm
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class LoginForm extends AbstractForm
{
    protected $action = '/';
    protected $width  = 200;
    protected $map    = 232;
    protected $method = 'post';
    protected $name   = 'login';

    /**
     * Конструктор
     */
    final public function __construct()
    {
        $this->init();

        $this->addElement(
            new TextElement('login', null, new RegEx('/^\w{1,10}$/'), true)
        );
        $this->addElement(
            new PasswordElement('password', null, new RegEx('/^\w{1,10}$/'), true)
        );
        $this->addElement(
            new ButtonElement('Submit', 'submit')
        );
    }
}
