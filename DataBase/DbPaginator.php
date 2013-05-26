<?php
/**
 * Class for data pagination
 * @file    DbPaginator.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Авг 07 23:04:47 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

use Veles\View\View;

/**
 * Class DbPaginator
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class DbPaginator
{
	// Data, wihich will be used for rendering
	protected $data = array();

	protected $offset = 1;
	protected $limit  = 5;
	protected $page_nums;
	protected $curr_page;
	protected $template;

	/**
	 * Constructor
	 * @param bool|string $template Path to template
	 * @param int $curr_page Current page
	 */
	final public function __construct($template = false, $curr_page = 1)
	{
		$this->template = ($template)
			? $template
			: 'paginator_default.phtml';

		$this->curr_page = (int) $curr_page;
	}

	/**
	 * Pagination rendering
	 */
	final public function __toString()
	{
		$vars = array(
			'curr_page' => $this->curr_page,
			'page_nums' => $this->page_nums,
			'first_link' => false,
			'last_link'  => false,
			'i'          => 1
		);
		if ($this->curr_page > 4) {
			$vars['first_link'] = 1;
			$vars['i'] = $this->curr_page - 3;
		}

		if ($this->page_nums > $this->curr_page + 3) {
			$vars['page_nums'] = $this->curr_page + 3;
			$vars['last_link'] = $this->page_nums;
		}
		$vars = array_merge($vars, $this->data);
		View::set($vars);

		return View::get($this->template);
	}

	/**
	 * Getting offset
	 * @return int
	 */
	final public function getOffset()
	{
		return ($this->curr_page - 1) * $this->getLimit();
	}

	/**
	 * Getting limit
	 * @return int
	 */
	final public function getLimit()
	{
		return $this->limit;
	}

	/**
	 * Elements per page setting
	 * @param int $limit Кол-во выводимых элементов на странице
	 */
	final public function setLimit($limit)
	{
		if (!is_numeric($limit)) {
			return;
		}

		$this->limit = (int) $limit;
	}

	/**
	 * Getting limit for sql-request
	 * @return string
	 */
	final public function getSqlLimit()
	{
		$offset = $this->getOffset();
		$limit  = $this->getLimit();
		return " LIMIT $offset, $limit";
	}

	/**
	 * Pages quantity
	 */
	final public function getMaxPages()
	{
		if (null !== $this->page_nums) {
			return $this->page_nums;
		}

		$this->calcMaxPages();

		return $this->page_nums;
	}

	/**
	 * Pages quantity calculation
	 */
	final public function calcMaxPages()
	{
		$this->page_nums = (int) ceil(Db::getFoundRows() / $this->getLimit());
	}

	/**
	 * Getting current page
	 */
	final public function getCurrPage()
	{
		return $this->curr_page;
	}

	/**
	 * Магия для создания доп. свойств постраничного вывода
	 * @param string $name
	 * @param mixed  $value
	 */
	final public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	/**
	 * Магия для доступа к свойствам постраничного вывода
	 * @param string $name
	 * @return mixed
	 */
	final public function __get($name)
	{
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}

		return null;
	}
}
