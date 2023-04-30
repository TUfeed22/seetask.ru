<?php

namespace Models;

use Database\ConnectionDB;
use PDO;
use PDOException;
use Exception;

class DataMapper
{

	/**
	 * Создание пользователя
	 * @throws Exception
	 */
	public function create($model): bool
	{
		// удаление пустых элементов
		$params = array_diff((array) $model, array(null, 'id'));

		$paramsConverting = self::convertingArrayToColumnNamesAndPseudoVariables($params);

		$query = "INSERT INTO " . $model->getTableName() . " (" . $paramsConverting->columnNames . ") VALUES (" . $paramsConverting->pseudoVariables . ")";
		$this->requestExecute($query, $params);

		return true;
	}

	/**
	 * Обновление пользователя
	 * @throws Exception
	 */
	public function update($model): bool
	{
		$params = (array) $model;
		$paramsConverting = self::substringPseudoVariables($params, ',');

		$query = "UPDATE " . $model->getTableName() . " SET " . $paramsConverting . " WHERE id = " . $model->id;
		$this->requestExecute($query, $params);

		return true;
	}

	/**
	 * @param string $query SQL запрос
	 * @param array $params Массив с данными для запроса
	 * @throws Exception
	 */
	protected function requestExecute(string $query, array $params): void
	{
		$connection = ConnectionDB::getInstance()->connection();
		try {
			$stmt = $connection->prepare($query);
			$stmt->execute($params);
			$stmt->closeCursor();
		} catch (PDOException $exception) {
			throw new PDOException("Произошла ошибка при выполнении запроса: " . $exception->getMessage());
		}
	}

	/**
	 * Выполняем запрос и возвращаем объект
	 *
	 * @param string $stdClass Имя класса создаваемого объекта
	 * @param string $query SQL запрос
	 * @param array $params Массив с данными для запроса
	 * @throws Exception
	 */
	protected function requestExecuteAndReturnFetchObject(string $stdClass, string $query, array $params)
	{
		$connection = ConnectionDB::getInstance()->connection();
		$object = '';
		$stmt = $connection->prepare($query);
		$stmt->execute($params);

		if (!empty($stmt)) {
			$object = $stmt->fetchObject($stdClass);
		}
		$stmt->closeCursor();
		return $object;
	}

	/**
	 * Выполняем запрос и возвращаем строку с данными
	 *
	 * @param string $query SQL запрос
	 * @param array $params Массив с данными для запроса
	 * @throws Exception
	 */
	protected function requestExecuteAndReturnRecord(string $query, array $params)
	{
		$connection = ConnectionDB::getInstance()->connection();

		$stmt = $connection->prepare($query);
		$stmt->execute($params);

		if (!empty($stmt)) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		$stmt->closeCursor();
		return false;
	}

	/**
	 * Перебираем ключи массива, это нужно для того, что бы при построении запроса использовать их как
	 * наименования колонок и псевдопеременные
	 * @param array $params
	 * @return object
	 * @throws Exception
	 */
	private function convertingArrayToColumnNamesAndPseudoVariables(array $params): object
	{
		// выбрасываем исключение, если массив не ассоциативный
		if (array_is_list($params)){
			throw new Exception('Массив должен иметь формат: key => value');
		}

		$columns = [];
		$prepareColumns = [];

		foreach ($params as $key => $value) {
			$columns[] = $key;
			$prepareColumns[] = ':' . $key;
		}

		// преобразуем массивы ключей и псевдопеременных в строки
		$columnNames = implode(',', $columns); // наименования колонок
		$pseudoVariables = implode(',', $prepareColumns); // псевдопеременные

		return (object) ['columnNames' => $columnNames, 'pseudoVariables' => $pseudoVariables];
	}

	/**
	 * Строка из параметров для sql запроса:
	 *
	 * Пример:
	 * 1. Разделитель - 'AND': key = :key AND key1 = :key1 AND key2 = :key2
	 * 2. Разделитель - запятая: key = :key, key1 = :key1, key2 = :key2
	 *
	 * @param array $params Ассоциативный массив с параметрами
	 * @param string $separator Разделитель
	 * @return string
	 */
	private function substringPseudoVariables(array $params, string $separator): string
	{
		$paramsToString = [];
		$result = '';
		foreach ($params as $key => $value) {
			$paramsToString[] .= $key . ' = :' . $key;
			$result = implode($separator, $paramsToString);
		}
		return $result;
	}

}