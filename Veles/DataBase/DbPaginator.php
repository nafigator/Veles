<?php
/**
 * Абстрактный класс для постраничного вывода
 * @file    DbPaginator.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 07 23:04:47 2012
 * @version
 */

namespace Veles\DataBase;

/**
 * Класс DbPaginator
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class DbPaginator
{
    protected $offset = 1;
    protected $limit  = 5;
    protected $key    = 'id';
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
        return ($this->curr_page - 1) * $this->limit;
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
     * Метод получения limit для sql-запроса
     * @return string
     */
    final public function getSqlLimit()
    {
        $offset = $this->getOffset();
        return " LIMIT $offset, $this->limit";
    }

    /**
     * Рендеринг ссылок постраничной навигации
     */
    final public function render()
    {
        require $template;
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
        $this->page_nums = (int) ceil(Db::getFoundRows() / $this->limit);
    }

    /**
     * Получение текущей страницы
     */
    final public function getCurrPage()
    {
        return $this->curr_page;
    }

    /**
     * Получение primary key
     */
    final public function getPrimaryKey()
    {
        return $this->key;
    }

    /**
     * Установка primary key
     * @param string $key Имя primary key
     */
    final public function setPrimaryKey($key)
    {
        $this->key = $key;
    }
}
