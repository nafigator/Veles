<?php
/**
 * Базовый класс для email-сообщений
 * @file    AbstractEmail.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Июл 17 21:58:01 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Email;

use \SplSubject;

/**
 * Класс AbstractEmail
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractEmail
{
    protected $to       = null;
    protected $headers  = null;
    protected $subject  = null;
    protected $message  = null;
    protected $charset  = 'utf-8';
    protected $encoding = 'base64';   //8bit

    /**
     * Вызов
     * @param array $vars Набор переменных
     */
    final public function update(SplSubject $subject)
    {
        $this->message = base64_encode($subject->getMessage());
        $this->init();
        $this->send();
    }

    /**
     * Создание сообщения
     */
    abstract public function init();

    /**
     * Отправка письма
     */
    final protected function send()
    {
        mail($this->to, $this->subject, $this->message, $this->headers);
    }
}
