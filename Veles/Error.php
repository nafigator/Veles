<?php
/**
 * Обработка ошибок проекта
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
    \SplObserver,
    \Veles\Email\ErrorEmail,
    \Veles\DataBase\DbException;

/**
 * Класс Error
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Error implements SplSubject
{
    private $vars      = null;
    private $observers = array();

    /**
     * Обработчик пользовательских ошибок
     */
    final public function error($type, $message, $file, $line, $defined)
    {
        $this->vars['type']    = $this->getErrorType($type);
        $this->vars['time']    = strftime("%Y-%m-%d %H:%M:%S", $_SERVER['REQUEST_TIME']);
        $this->vars['message'] = $message;
        $this->vars['file']    = str_replace(BASE_PATH, '', $file);
        $this->vars['line']    = $line;
        $this->vars['stack']   = $this->getStack(array_reverse(debug_backtrace()));
        $this->vars['defined'] = $defined;

        $this->process();
    }

    /**
     * Обработчик php ошибок
     */
    final public function fatal()
    {
        if (null === ($this->vars = error_get_last())) exit;

        $this->vars['type']    = $this->getErrorType($this->vars['type']);
        $this->vars['time']    = strftime("%Y-%m-%d %H:%M:%S", $_SERVER['REQUEST_TIME']);
        $this->vars['file']    = str_replace(BASE_PATH, '', $this->vars['file']);
        $this->vars['stack']   = array();
        $this->vars['defined'] = array();

        $this->process();
    }

    /**
     * Обработчик исключений
     * @param Exception $e Исключение
     */
    final public function exception($e)
    {
        $this->vars['type']    = $this->getErrorType($e->getCode());
        $this->vars['time']    = strftime("%Y-%m-%d %H:%M:%S", $_SERVER['REQUEST_TIME']);
        $this->vars['message'] = $e->getMessage();
        $this->vars['file']    = str_replace(BASE_PATH, '', $e->getFile());
        $this->vars['line']    = $e->getLine();
        $this->vars['stack']   = $this->getStack(array_reverse($e->getTrace()));
        $this->vars['defined'] = ($e instanceof DbException)
            ? array(
                'connect_error' => $e->getConnectError(),
                'sql_error'     => $e->getSqlError(),
                'sql_query'     => $e->getSqlQuery())
            : array();

        $this->process();
    }

    /**
     * Метод обработки исключений
     */
    final public function process()
    {
        if ('development' === ENVIRONMENT) {
            View::set($this->vars);
            View::show('error/exception.phtml');
        }
        else {
            View::set($this->vars);
            $error_output = View::get('error', 'exception');

            //TODO: $this->attach(new ErrorSMS($this->vars));
            $this->attach(new ErrorEmail($error_output));
            $this->notify();

            //TODO: go to custom error page;
            exit;
        }
    }

    /**
     * Получение типа ошибки
     * @param string $type
     * @return string
     */
    private function getErrorType($type)
    {
        switch ((int) $type) {
            case E_ERROR:               // 1
                return 'FATAL ERROR';
            case E_WARNING:             // 2
                return 'WARNING';
            case E_PARSE:               // 4
                return 'PARSE ERROR';
            case E_NOTICE:              // 8
                return 'NOTICE';
            case E_CORE_ERROR:          // 16
                return 'CORE ERROR';
            case E_CORE_WARNING:        // 32
                return 'CORE WARNING';
            case E_CORE_ERROR:          // 64
                return 'COMPILE ERROR';
            case E_CORE_WARNING:        // 128
                return 'COMPILE WARNING';
            case E_USER_ERROR:          // 256
                return 'USER ERROR';
            case E_USER_WARNING:        // 512
                return 'USER WARNING';
            case E_USER_NOTICE:         // 1024
                return 'USER NOTICE';
            case E_STRICT:              // 2048
                return 'STRICT NOTICE';
            case E_RECOVERABLE_ERROR:   // 4096
                return 'RECOVERABLE ERROR';
            case E_DEPRECATED:          // 8192
                return 'DEPRECATED WARNING';
            case E_USER_DEPRECATED:     // 16384
                return 'USER DEPRECATED WARNING';
            case 0:
                return 'EXCEPTION';
        }
    }

    /**
     * Форматирование стека вызовов
     * @param array $stack Массив вызовов
     */
    private function getStack($stack)
    {
        foreach ($stack as $key => &$call) {
            $call['function'] = (isset($call['class']))
                ? $call['class'] . $call['type'] . $call['function']
                : $call['function'];

            $call['file'] = (isset($call['file']))
                ? $call['file'] . '<b>:</b>' . $call['line']
                : '';
        }

        return $stack;
    }

    /**
     * Метод уведомления наблюдателей об ошибке
     */
    final public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * Метод добавления наблюдателей
     */
    final public function attach(SplObserver $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * Метод удаления наблюдателей
     */
    final public function detach(SplObserver $observer)
    {

    }
}
