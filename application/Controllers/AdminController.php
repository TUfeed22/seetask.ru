<?php
namespace application\Controllers;
use application\Views\BaseView;
use application\Controllers\Tool\Tool;
use Exception;
use application\Models\User\AuthenticationUser;
use application\Views\User\UserView;


class AdminController extends BaseController
{
	/**
	 * Страница авторизации пользователя
	 * @throws Exception
	 */
  public function login(): void
  {
	  $userView = new UserView('Регистрация', 'admin/auth/layout.php');
	  $userView->renderContent('admin/auth/login.php');
	  $userView->render();
  }

	/**
	 * Страница регистрации пользователя
	 * @throws Exception
	 */
  public function register(): void
  {
	  $userView = new UserView('Регистрация', 'admin/auth/layout.php');
		$userView->renderContent('admin/auth/register.php');
	  $userView->render();
  }

	/**
	 * Выход
	 * @return void
	 */
	public function logout(): void
	{
		$_SESSION['auth'] = false;
		header('Location: /admin/login/');
	}

	/**
	 * Страница админпанели
	 * @throws Exception
	 */
  public function index(): void
  {
	  $this->isCurrentUserLoggedIn();
	  $data = [
			'title' => 'Информационная панель',
	  ];

	  $userView = new UserView('Информационная панель', 'layout.php');
	  $userView->renderContent('admin/index.php', $data);
	  $userView->render();

  }

	/**
	 * Получаем данные авторизации с фронта,
	 * далее передаем их в модель, из модели получаем ответ о правильности данных и передаем его в представление.
	 *
	 * @throws Exception
	 */
  public function authorizationData(): void
  {
		// проверка токена
    if (!Tool::checkCsrfToken(htmlspecialchars($_POST['token']))) {
	    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
	    exit;
    }

    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    $userAuthentication = new AuthenticationUser();

	  self::response($userAuthentication->authorization($login, $password)); // передаем ответ
  }

  /**
   * Получаем данные регистрации с фронта, далее передаем их в модель,
   * из модели получаем ответ о статусе регистрации (успех/неудача) данных и передаем его в представление.
   *
   * @throws Exception
   */
  public function registrationData(): void
  {
	  // проверка токена
	  if (!Tool::checkCsrfToken(htmlspecialchars($_POST['token']))) {
		  header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
		  exit;
	  }

    $email = htmlspecialchars($_POST['email']);
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

	  $userAuthentication = new AuthenticationUser();

	  self::response($userAuthentication->registration($email, $login, $password));
  }
}