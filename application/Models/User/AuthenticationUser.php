<?php

namespace Models\User;

use Exception;

class AuthenticationUser
{

	/**
	 * Регистрация пользователя
	 *
	 * @param string $email
	 * @param string $login
	 * @param string $password
	 * @return array
	 * @throws Exception
	 */
	public function registration(string $email, string $login, string $password): array
	{
		$user = new User();
		$mapperUser = new DataMapperUser();
		// результат и ответ для запроса с фронта
		$result = [];

		// свободен ли email
		if ($mapperUser->getEmail($email)) {
			return ['email' => true];
		}
		$result['email'] = false;

		// свободен ли логин
		if ($mapperUser->getLogin($login)) {
			return ['login' => true];
		}
		$result['login'] = false;

		$user->email = $email;
		$user->login = $login;
		$user->password = $password;

		$result['status'] = $mapperUser->create($user);

		return $result;
	}

	/**
	 * Авторизация пользователя
	 *
	 * @param string $login
	 * @param string $password
	 * @return array
	 * @throws Exception
	 */
	public function authorization(string $login, string $password): array
	{
		$mapperUser = new DataMapperUser();
		$user = $mapperUser->getByLogin($login);

		// если пользователь найден по логину, проверяем пароль
		if ($user->password == $password) {
			// сохраняем данные в сессию
			$_SESSION['user_id'] = $user->id;
			$_SESSION['auth'] = true; // пользователь авторизован
			return ['status' => true];
		}
		return ['status' => false];
	}

}