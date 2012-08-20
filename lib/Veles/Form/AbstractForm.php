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

use \Veles\Validators\RegEx,
    \Veles\Form\Elements\iElement,
    \Veles\Form\Elements\ButtonElement,
    \Veles\Form\Elements\HiddenElement,
    \Veles\Form\Elements\SubmitElement;

/**
 * Класс AbstractForm
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractForm
{
    protected $method = 'post';
    protected $width  = null;
    protected $name   = null;
    protected $key    = null;
    protected $id     = null;
    protected $class  = null;

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
    final public function __toString()
    {
        $output  = '<form ';
        if (null !== $this->id)
            $output .= "id =\"$this->id\" ";

        if (null !== $this->class)
            $output .= "class =\"$this->class\" ";

        if (null !== $this->name)
            $output .= "name =\"$this->name\" ";

        $output .= "action=\"$this->action\" method=\"$this->method\">";

        foreach ($this->elements as $element) {
            $output .= $element->render();
        }

        $output .= '</form>';

        return $output;
    }
}
