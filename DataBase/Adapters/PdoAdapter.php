<?php
namespace Veles\DataBase\Adapters;

use PDO;

/**
 * Class PdoAdapter
 *
 * Адаптер для php-расширения PDO
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class PdoAdapter extends DbAdapterBase implements iDbAdapter
{
	// Храним стейтмент для возможности получения ошибок в подписчиках
	/** @var  \PDOStatement */
	private $stmt;

	private $type = array(
	   'i' => PDO::PARAM_INT,
	   'd' => PDO::PARAM_STR,
	   's' => PDO::PARAM_STR,
	   'b' => PDO::PARAM_LOB
	);

	private function bindParams($params, $types)
	{
		foreach ($params as $key => $param) {
			$type = isset($this->type[$types[$key]])
				? $this->type[$types[$key]]
				: PDO::PARAM_STR;
			// Placeholder numbers begins from 1
			$this->stmt->bindValue($key + 1, $param, $type);
		}
	}

	/**
	 * Получение значения столбца таблицы
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return string
	 */
	public function value($sql, array $params, $types)
	{
		$this->stmt = $this->getConnection()->prepare($sql);

		if (null === $types) {
			$this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$this->stmt->execute();
		}

		$this->notify();

		return $this->stmt->fetchColumn();
	}

	/**
	 * Получение строки таблицы в виде ассоциативного массива
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return array
	 */
	public function row($sql, array $params, $types)
	{
		$this->stmt = $this->getConnection()->prepare($sql);

		if (null === $types) {
			$this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$this->stmt->execute();
		}

		$this->notify();

		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * Получение результата в виде коллекции ассоциативных массивов
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return mixed
	 */
	public function rows($sql, array $params, $types)
	{
		$this->stmt = $this->getConnection()->prepare($sql);

		if (null === $types) {
			$this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$this->stmt->execute();
		}

		$this->notify();

		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Инициализация транзакции
	 *
	 * @return bool
	 */
	public function begin()
	{
		return $this->getConnection()->beginTransaction();
	}

	/**
	 * Откат транзакции
	 *
	 * @return bool
	 */
	public function rollback()
	{
		return $this->getConnection()->rollBack();
	}

	/**
	 * Сохранение всех запросов транзакции и её закрытие
	 *
	 * @return bool
	 */
	public function commit()
	{
		return $this->getConnection()->commit();
	}

	/**
	 * Запуск произвольного не SELECT запроса
	 *
	 * @param string $sql Non-SELECT SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return bool
	 */
	public function query($sql, array $params, $types)
	{
		$this->stmt = $this->getConnection()->prepare($sql, $params);

		if (null === $types) {
			$result = $this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$result = $this->stmt->execute();
		}

		$this->notify();

		return $result;
	}

	/**
	 * Получение последнего сохранённого ID
	 *
	 * @return int
	 */
	public function getLastInsertId()
	{
		return (int) $this->getConnection()->lastInsertId();
	}

	/**
	 * Получение кол-ва строк в результате
	 *
	 * @return int
	 */
	public function getFoundRows()
	{
		$this->stmt = $this->getConnection()->query('SELECT FOUND_ROWS()');

		$this->notify();

		return (int) $this->stmt->fetchColumn();
	}

	/**
	 * Получение PDOStatement
	 *
	 * Используется подписчиками для получения информации об ошибках
	 *
	 * @return mixed
	 */
	public function getStmt()
	{
		return $this->stmt;
	}

	/**
	 * Escape variable
	 *
	 * @param string $var
	 * @return string
	 */
	public function escape($var)
	{
		return $this->getConnection()->quote($var);
	}
}
