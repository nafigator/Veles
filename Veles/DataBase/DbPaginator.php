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
    protected $offset = 0;
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
            : BASE_PATH . 'lib/Veles/View/default.phtml';

        $this->curr_page = $curr_page;
    }

    /**
     * Метод получения offset
     * @return int
     */
    final public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Метод получения limit
     * @return int
     */
    final public function getLimit()
    {
        return "LIMIT $this->limit";
    }

    /**
     * Рендеринг ссылок постраничной навигации
     */
    final public function render()
    {
        require $template;
    }
}
