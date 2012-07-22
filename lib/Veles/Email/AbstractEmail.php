<?php
/**
 * Базовый класс для email-сообщений
 * @file    AbstractEmail.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Июл 17 21:58:01 2012
 * @version
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
     * Конструктор
     * @param string $message Тело сообщения
     */
    final public function __construct($message) {
        $this->message = $message;
    }

    /**
     * Вызов
     * @param array $vars Набор переменных
     */
    final public function update(SplSubject $subject)
    {
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
