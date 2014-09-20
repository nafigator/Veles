<?php
namespace Veles\DataBase\Connections;

use Exception;
use PDO;

/**
 * Class PdoConnection
 *
 * Класс-контейнер для хранения PDO-соединений и их параметров
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class PdoConnection extends DbConnection
{
	/** @var string */
	protected $dsn;
	/** @var array */
	protected $options;

	/**
	 * Создание соединения
	 *
	 * Реализуется в конкретном классе для каждого типа соединений
	 *
	 * @param array $calls Array with lazy calls
	 *
	 * @return mixed
	 */
	public function create(array $calls = array())
	{
		$this->resource = new PDO(
			$this->getDsn(), $this->getUserName(),
			$this->getPassword(), $this->getOptions()
		);

		foreach ($calls as $call) {
			call_user_func_array(
				array($this->resource, $call['method']),
				$call['arguments']
			);
		}

		return $this;
	}

	/**
	 * @param string $dsn
	 * @return $this
	 */
	public function setDsn($dsn)
	{
		$this->dsn = $dsn;
		return $this;
	}

	/**
	 * @throws Exception
	 * @return string
	 */
	public function getDsn()
	{
		if (null === $this->dsn) {
			throw new Exception('DSN соединения не установлен.');
		}
		return $this->dsn;
	}

	/**
	 * @param array $options
	 * @return $this
	 */
	public function setOptions(array $options)
	{
		$this->options = $options;
		return $this;
	}

	/**
	 * @throws Exception
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}
}
