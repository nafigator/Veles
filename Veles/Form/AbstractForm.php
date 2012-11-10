<?php
/**
 * Базовый класс форм
 * @file    AbstractForm.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Авг 12 10:30:52 2012
 * @version
 */

namespace Veles\Form;

use \Veles\View,
    \Veles\Validators\RegEx,
    \Veles\Form\Elements\iElement,
    \Veles\Form\Elements\ButtonElement,
    \Veles\Form\Elements\HiddenElement,
    \Veles\Form\Elements\SubmitElement;

/**
 * Класс AbstractForm
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractForm implements iForm
{
    protected $method   = 'post';
    protected $template = null;

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
        $this->key  = crc32($this->name);

        $this->addElement(new HiddenElement(array(
            'validator'  => new RegEx('/^$/'),
            'required'   => true,
            'attributes' => array('name' => $this->key)
        )));
    }

    /**
     * Добавление элемента формы
     * @param Element $element Экземпляр элемента формы
     */
    final public function addElement(iElement $element)
    {
        $this->elements[] = $element;
    }

    /**
     * Валидатор формы
     */
    final public function valid()
    {
        $valid = true;

        foreach ($this->elements as $element) {
            if ($element instanceof ButtonElement || $element instanceof SubmitElement)
                continue;

            $name = $element->getName();

            if (!isset($this->data[$name])) {
                if ($element->required())
                    $valid = false;

                continue;
            }

            if (!$element->validate($this->data[$name]))
                $valid = false;
        }

        return $valid;
    }

    /**
     * Проверка была ли отправлена форма
     */
    final public function submitted()
    {
        return isset($this->data[$this->key]) && '' === $this->data[$this->key];
    }


    /**
     * Вывод формы
     */
    public function __toString()
    {
        $elements = $tpl = array();
        $output   = View::get('frontend/forms/comment.phtml');

        foreach ($this->elements as $number => $element) {
            $elements[] = $element->render($this);
            $tpl[]      = "#$number#";
        }

        return str_replace($tpl, $elements, $output);
    }

    /**
     * Получение общего шаблона для элементов
     * @return string|bool
     */
    final public function getElementsTpl()
    {
        return $this->elements_template;
    }
}
