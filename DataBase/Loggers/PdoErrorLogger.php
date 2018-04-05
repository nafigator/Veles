<?php
/**
 * Class for logging PDO errors. Subscriber for PDO-adapter
 *
 * @file      PdoErrorLogger.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      2013-12-31 15:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\DataBase\Loggers;

use SplSubject;
use Veles\DataBase\Adapters\DbAdapterInterface;

/**
 * Class PdoErrorLogger
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class PdoErrorLogger implements \SplObserver
{
	/** @var  string */
	protected $path;
	/** @var \PDO */
	protected $conn;
	/** @var \PDOStatement */
	protected $stmt;

	/**
	 * Set log path
	 *
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * Getting log path
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Update subscriber
	 *
	 * @param SplSubject $subject
	 */
	public function update(SplSubject $subject)
	{
		$this->updateConnParams($subject);
		$conn_err = $this->conn->errorCode();
		$stmt_err = $this->stmt->errorCode();

		if ('00000' === $conn_err && '00000' === $stmt_err) {
			return;
		}

		$error_info = ('00000' === $conn_err)
			? implode('; ', $this->stmt->errorInfo()) . PHP_EOL
			: implode('; ', $this->conn->errorInfo()) . PHP_EOL;

		error_log($error_info, 3, $this->getPath());
	}

	/**
	 * Set connection and statement properties
	 *
	 * @param SplSubject $subject
	 */
	protected function updateConnParams(SplSubject $subject)
	{
		if (!$subject instanceof DbAdapterInterface) {
			$msg = '$subject must be instance of InvalidArgumentException';
			throw new \InvalidArgumentException($msg);
		}

		$this->conn = $subject->getResource();
		$this->stmt = $subject->getStmt();
	}
}
