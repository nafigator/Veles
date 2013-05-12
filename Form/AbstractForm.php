<?php
/**
 * Базовый класс форм
 * @file    AbstractForm.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Авг 12 10:30:52 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form;

use \Veles\View;
use \Veles\Cache\Cache;
use \Veles\Validators\RegEx;
use \Veles\Form\Elements\iElement;
use \Veles\Form\Elements\ButtonElement;
use \Veles\Form\Elements\HiddenElement;
use \Veles\Form\Elements\SubmitElement;

/**
 * Класс AbstractForm
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractForm implements iForm
{
    protected $method   = 'post';
    protected $template = null;
    protected $data     = null;
    protected $sid      = null;
    protected $name     = null;
    protected $action   = null;

    private $elements = array();

    /**
     * Конструктор
     * @param mixed $data Данные, которые могут понадобиться для генерации формы
     */
    abstract public function __construct($data = false);

    /**
     * Сохранение формы
     */
    abstract public function save();

    /**
     * Инициализиция значений по-умолчанию
     */
    final protected function init()
    {
        $this->data = ('get' === $this->method) ? $_GET : $_POST;
        $this->sid  = md5(mt_rand());

        $params = array(
            'validator'  => new RegEx('/^[a-f\d]{32}$/'),
            'required'   => true,
            'attributes' => array('name' => 'sid', 'value' => $this->sid)
        );
        $this->addElement(new HiddenElement($params));
    }

    /**
     * Добавление элемента формы
     * @param iElement $element Экземпляр элемента формы
     * @return void
     */
    final public function addElement(iElement $element)
    {
        $this->elements[] = $element;
    }

    /**
     * Валидатор формы
     * @return bool
     */
    final public function valid()
    {
        /** @var iElement $element*/
        foreach ($this->elements as $element) {
            if ($element instanceof ButtonElement
                || $element instanceof SubmitElement
            ) {
                continue;
            }

            $name = $element->getName();

            if (!isset($this->data[$name])) {
                if ($element->required()) {
                    return false;
                }

                continue;
            }

            if (!$element->validate($this->data[$name])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Проверка была ли отправлена форма
     * @return bool
     */
    final public function submitted()
    {
        if (!isset($this->data['sid'])) {
            return false;
        }

        $key = $this->name . $this->data['sid'];

        if (!Cache::get($key)) {
            return false;
        }

        return true;
    }

    /**
     * Очистка security-ключа формы
     */
    final public function cleanup()
    {
        $key = $this->name . $this->data['sid'];
        Cache::del($key);
    }

    /**
     * Вывод формы
     * @return string
     */
    final public function __toString()
    {
        $elements = $tpl = array();
        $output   = View::get($this->template);

        /** @var iElement $element */
        foreach ($this->elements as $number => $element) {
            $elements[] = $element->render($this);
            $tpl[]      = "#$number#";
        }

        $tpl      = array_merge($tpl, array("#method#", "#action#", "#name#"));
        $elements = array_merge(
            $elements,
            array(
                $this->method,
                $this->action,
                $this->name
            )
        );

        $this->saveSid();

        return str_replace($tpl, $elements, $output);
    }

    /**
     * Return form seciruty id
     *
     * Can be used for refresh sid after ajax-request
     *
     * @return string
     */
    final public function getSid()
    {
        return $this->sid;
    }

    /**
     * Save form secirity id to cache
     * @return bool
     */
    final public function saveSid()
    {
        return Cache::set($this->name . $this->sid, true, 7200);
    }
}
