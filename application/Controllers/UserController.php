<?php
namespace Controllers;

use Views\BaseView;
use Controllers\Tool\Tool;
use Exception;
use Models\User\DataMapperUser;
use Models\User\User;
use Views\User\UserView;


class UserController extends BaseController
{

	/**
	 * Страница мой профиль
	 * @throws Exception
	 */
	public function index(): void
	{
		$this->isCurrentUserLoggedIn();

		$currentUser = (new User())->currentUser();

		$userView = new UserView('Профиль пользователя', 'layout.php');
		$userView->renderContent('admin/user/profile.php', ['currentUser' => $currentUser]);
		$userView->render();
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	public function basicInformation(): void
	{
		$this->isCurrentUserLoggedIn();

		$user = (new User())->currentUser();
		$mapperUser = new DataMapperUser();
		$token = array_shift($_POST);

		// проверка токена
		if (!Tool::checkCsrfToken(htmlspecialchars($token))) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
			exit;
		}

		$fromData = [];
		foreach ($_POST as $key => $value) {
			$fromData[$key] = htmlspecialchars($value);
		}

		if ($mapperUser->getEmail($fromData['email']) && $user->email !== $fromData['email']) {
			self::response(['status' => false, 'message' => 'E-mail занят. Укажите другой.']);
			return;
		} else {
			$user->email = $fromData['email'];
		}

		if ($mapperUser->getlogin($fromData['login']) && $user->login !== $fromData['login']) {
			self::response(['status' => false, 'message' => 'Логин занят. Придумайте другой.']);
			return;
		} else {
			$user->login = $fromData['login'];
		}

		$user->firstname = $fromData['firstname'];
		$user->lastname = $fromData['lastname'];
		$user->city = $fromData['city'];

		if ($mapperUser->update($user)) {
			self::response(['status' => true, 'message' => 'Изменения сохранены.']);
		} else {
			self::response(['status' => false, 'message' => 'Ошибка сохранения.']);
		}
	}

}