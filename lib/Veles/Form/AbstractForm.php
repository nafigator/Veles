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

use \Veles\Form\Elements\iElement,
    \Veles\Validators\RegEx,
    \Veles\Form\Elements\HiddenElement,
    \Veles\Form\Elements\ButtonElement;

/**
 * Класс AbstractForm
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractForm
{
    private $method = 'post';
    private $action;
    protected $width;
    protected $map;
    protected $name;
    protected $key;

    private $elements = array();

    /**
     * Конструктор
     */
    abstract public function __construct();

    /**
     * Инициализиция значений по-умолчанию
     */
    final protected function init()
    {
        $this->data   = ('GET' === $this->action) ? $_GET : $_POST;
        $this->key    = crc32($this->name);

        $this->addElement(
            new HiddenElement($this->key, '', new RegEx('/^$/'), true)
        );
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
            if ($element instanceof ButtonElement)
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
    final public function __toString()
    {
        $output = <<<FORM
<form name="$this->name" action="$this->action" method="$this->method">
FORM;

        foreach ($this->elements as $element) {
            $output .= $element->render();
        }

        $output .= '</form>';

        return $output;
    }
}
