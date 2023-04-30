<?php

namespace Models\User;

use Models\DataMapper;
use Exception;

class DataMapperUser extends DataMapper
{

	/**
	 * Возвращаем пользователя по его id
	 * @return bool|User Объект пользователя
	 * @throws Exception
	 */
	public function getById($id): bool|User
	{
		if (!empty($id)) {
			$query = "SELECT * FROM " . User::getTableName() . " WHERE id = :id";
			return $this->requestExecuteAndReturnFetchObject(User::class, $query, ['id' => $id]);
		} else {
			throw new Exception("Переменная id пустая.");
		}
	}

	/**
	 * Возвращаем пользователя по его логину
	 *
	 * @param string $login Логин пользователя
	 * @return bool|User Объект пользователя
	 * @throws Exception
	 */
	public function getByLogin(string $login): bool|User
	{
		if (!empty($login)) {
			$query = "SELECT * FROM " . User::getTableName() . " WHERE login = :login";
			return $this->requestExecuteAndReturnFetchObject(User::class, $query, ['login' => $login]);
		} else {
			throw new Exception("Переменная login пустая.");
		}
	}

	/**
	 * @throws Exception
	 */
	public function getEmail($email)
	{
		if (!empty($email)) {
			$query = "SELECT email FROM " . User::getTableName() . " WHERE email = :email";
			return $this->requestExecuteAndReturnRecord($query, ['email' => $email]);
		} else {
			throw new Exception("Переменная email пустая.");
		}
	}

	/**
	 * @throws Exception
	 */
	public function getLogin($login)
	{
		if (!empty($login)) {
			$query = "SELECT login FROM " . User::getTableName() . " WHERE login = :login";
			return $this->requestExecuteAndReturnRecord($query, ['login' => $login]);
		} else {
			throw new Exception("Переменная login пустая.");
		}
	}

}