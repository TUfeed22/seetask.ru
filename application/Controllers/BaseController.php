<?php

namespace application\Controllers;

class BaseController
{
	/**
	 * Вошел ли текущий пользователь в систему
	 * @return void
	 */
	protected function isCurrentUserLoggedIn(): void
	{
		if (!$_SESSION['auth']) {
			header('Location: /admin/login/');
		}
	}

	/**
	 * Ответ на запрос с js
	 * @param array $result
	 * @return void
	 */
	protected function response(array $result): void
	{
		header('Content-Type: application/json');
		echo json_encode($result);
	}

}