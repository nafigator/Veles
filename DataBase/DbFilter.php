<?php
/**
 * Filter for usage in models
 *
 * @file      DbFilter.php
 *
 * PHP version 7.1+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      Втр Авг 07 23:14:17 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\DataBase;

/**
 * Class DbFilter
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class DbFilter
{
	protected $where  = '';
	protected $group  = '';
	protected $having = '';
	protected $order  = '';

	/**
	 * Gets where conditions
	 *
	 * @return string
	 */
	public function getWhere()
	{
		return $this->where;
	}

	/**
	 * Gets group by conditions
	 * @return string
	 */
	public function getGroup()
	{
		return $this->group;
	}

	/**
	 * Gets having conditions
	 *
	 * @return string
	 */
	public function getHaving()
	{
		return $this->having;
	}

	/**
	 * Gets order by conditions
	 *
	 * @return string
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * Sets where conditions
	 *
	 * @param string $where WHERE для sql-запроса
	 *
	 * @return $this
	 */
	public function setWhere($where)
	{
		$this->where = "WHERE $where";

		return $this;
	}

	/**
	 * Sets group by conditions
	 *
	 * @param string $group GROUP BY для sql-запроса
	 *
	 * @return $this
	 */
	public function setGroup($group)
	{
		$this->group = "GROUP BY $group";

		return $this;
	}

	/**
	 * Sets having conditions
	 *
	 * @param string $having HAVING для sql-запроса
	 *
	 * @return $this
	 */
	public function setHaving($having)
	{
		$this->having = "HAVING $having";

		return $this;
	}

	/**
	 * Sets order by conditions
	 *
	 * @param string $order ORDER BY для sql-запроса
	 *
	 * @return $this
	 */
	public function setOrder($order)
	{
		$this->order = "ORDER BY $order";

		return $this;
	}
}
