<?php
namespace Veles\DataBase\Connections;

use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\DebugBar;
use PDO;

/**
 * Class PdoConnection
 *
 * Класс-контейнер для хранения PDO-соединений и их параметров предназначенный
 * для взаимодействия с DebugBar
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class TraceablePdoConnection extends PdoConnection
{
	/** @var  DebugBar */
	private $bar;

	/**
	 * Создание соединения
	 *
	 * Реализуется в конкретном классе для каждого типа соединений
	 *
	 * @param array $calls Array with lazy calls
	 *
	 * @return mixed
	 */
	public function create(array $calls = [])
	{
		$this->resource = new TraceablePDO(new PDO(
			$this->getDsn(), $this->getUserName(),
			$this->getPassword(), $this->getOptions()
		));

		foreach ($calls as $call) {
			call_user_func_array(
				[$this->resource, $call['method']],
				$call['arguments']
			);
		}

		if (!$this->bar->hasCollector('pdo')) {
			$pdoCollector = new PDOCollector();
			$pdoCollector->addConnection($this->resource, $this->getName());
			$this->bar->addCollector($pdoCollector);
		} else {
			$pdoCollector = $this->bar->getCollector('pdo');
			/** @noinspection PhpUndefinedMethodInspection */
			$pdoCollector->addConnection($this->resource, $this->getName());
		}

		return $this;
	}

	/**
	 * Устанавливаем объект панели
	 *
	 * @param DebugBar $bar Объект дебаг-панели
	 * @return $this
	 */
	public function setBar($bar)
	{
		$this->bar = $bar;
		return $this;
	}
}
