<?php
namespace Veles\DataBase\Adapters;

/**
 * Interface iDbAdapter
 *
 * Интерфейс для Db адаптеров
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
interface iDbAdapter
{
	/**
	 * Получение значения столбца таблицы
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return string
	 */
	public function value($sql, array $params, $types);

	/**
	 * Получение строки таблицы в виде ассоциативного массива
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return array
	 */
	public function row($sql, array $params, $types);

	/**
	 * Получение результата в виде коллекции ассоциативных массивов
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return array
	 */
	public function rows($sql, array $params, $types);

	/**
	 * Инициализация транзакции
	 *
	 * @return bool
	 */
	public function begin();

	/**
	 * Откат транзакции
	 *
	 * @return bool
	 */
	public function rollback();

	/**
	 * Сохранение всех запросов транзакции и её закрытие
	 *
	 * @return bool
	 */
	public function commit();

	/**
	 * Запуск произвольного не SELECT запроса
	 *
	 * @param string $sql Non-SELECT SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return bool
	 */
	public function query($sql, array $params, $types);

	/**
	 * Получение последнего сохранённого ID
	 *
	 * @return int
	 */
	public function getLastInsertId();

	/**
	 * Получение кол-ва строк в результате
	 *
	 * @return int
	 */
	public function getFoundRows();

	/**
	 * Получение statement
	 *
	 * Используется подписчиками для получения информации об ошибках
	 *
	 * @return mixed
	 */
	public function getStmt();

	/**
	 * Escape variable
	 *
	 * @param string $var
	 * @return string
	 */
	public function escape($var);
}
