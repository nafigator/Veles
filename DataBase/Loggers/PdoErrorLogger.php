<?php
namespace Veles\DataBase\Loggers;

use SplSubject;

/**
 * Class PdoErrorLogger
 *
 * Класс-подписчик PDO-адаптера. Предназначен для логгирования ошибок
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class PdoErrorLogger implements \SplObserver
{
	/** @var  string */
	private $path;

	/**
	 * Установка пути к логу
	 *
	 * @param string $path  Путь к логу
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * Получение пути к логу
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Получение обновления
	 *
	 * @param SplSubject $subject
	 */
	public function update(SplSubject $subject)
	{
		$conn = $subject->getConnection();
		$conn_err = $conn->errorCode();
		$stmt = $subject->getStmt();
		$stmt_err = $stmt->errorCode();

		if ('00000' === $conn_err and '00000' === $stmt_err)
			return;

		$error_info = ('00000' === $conn_err)
			? implode('; ', $stmt->errorInfo()) . PHP_EOL
			: implode('; ', $conn->errorInfo()) . PHP_EOL;

		error_log($error_info, 3, $this->getPath());
	}
}
