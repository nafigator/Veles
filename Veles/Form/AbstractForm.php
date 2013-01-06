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

use \Cache,
    \Veles\View,
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
    protected $data     = null;
    protected $sid      = null;

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

        $this->addElement(new HiddenElement(array(
            'validator'  => new RegEx('/^[a-f\d]{32}$/'),
            'required'   => true,
            'attributes' => array('name' => 'sid', 'value' => $this->sid)
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
        foreach ($this->elements as $element) {
            if ($element instanceof ButtonElement || $element instanceof SubmitElement)
                continue;

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
     */
    final public function submitted()
    {
        if (!isset($this->data['sid']))
            return false;

        $key = $this->name . $this->data['sid'];

        if (!Cache::get($key))
            return false;

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
     */
    public function __toString()
    {
        $elements = $tpl = array();
        $output   = View::get($this->template);

        foreach ($this->elements as $number => $element) {
            $elements[] = $element->render($this);
            $tpl[]      = "#$number#";
        }

        Cache::set($this->name . $this->sid, true, 7200);

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
