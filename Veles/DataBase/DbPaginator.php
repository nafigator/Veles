<?php
/**
 * Абстрактный класс для постраничного вывода
 * @file    DbPaginator.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 07 23:04:47 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

/**
 * Класс DbPaginator
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class DbPaginator
{
    // Данные, которые могут быть задействованы при отрисовке
    protected $data = array();

    protected $offset = 1;
    protected $limit  = 5;
    protected $page_nums;
    protected $curr_page;
    protected $template;

    /**
     * Конструктор
     * @param string $template Путь к шаблону постраничной навигации
     */
    final public function __construct($template = false, $curr_page = 1)
    {
        $this->template = ($template)
            ? $template
            : BASE_PATH . 'lib/Veles/View/paginator_default.phtml';

        $this->curr_page = $curr_page;
    }

    /**
     * Отрисовка постраничного вывода
     */
    final public function __toString()
    {
        require $this->template;
        return '';
    }

    /**
     * Метод получения offset
     * @return int
     */
    final public function getOffset()
    {
        return ($this->curr_page - 1) * $this->getLimit();
    }

    /**
     * Метод получения limit
     * @return int
     */
    final public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Метод установки кол-ва элементов на страницу
     * @param int $limit Кол-во выводимых элементов на странице
     */
    final public function setLimit($limit)
    {
        if (!is_numeric($limit))
            return;

        $this->limit = (int) $limit;
    }

    /**
     * Метод получения limit для sql-запроса
     * @return string
     */
    final public function getSqlLimit()
    {
        $offset = $this->getOffset();
        $limit  = $this->getLimit();
        return " LIMIT $offset, $limit";
    }

    /**
     * Получение кол-ва страниц
     */
    final public function getMaxPages()
    {
        if (null !== $this->page_nums)
            return $this->page_nums;

        $this->calcMaxPages();

        return $this->page_nums;
    }

    /**
     * Подсчёт кол-ва страниц
     */
    final public function calcMaxPages()
    {
        $this->page_nums = (int) ceil(Db::getFoundRows() / $this->getLimit());
    }

    /**
     * Получение текущей страницы
     */
    final public function getCurrPage()
    {
        return $this->curr_page;
    }

    /**
     * Магия для создания доп. свойств постраничного вывода
     * @param stirng $name
     * @param mixed  $value
     */
    final public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Магия для доступа к свойствам постраничного вывода
     * @param string $name
     */
    final public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }
}
