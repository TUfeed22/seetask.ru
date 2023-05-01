<?php

namespace application\Controllers;

use Exception;
use application\Views\Project\ProjectView;

class TaskController extends BaseController
{
	/**
	 * Страница Проекты
	 * @throws Exception
	 */
	public function index(): void
	{
		$this->isCurrentUserLoggedIn();

		$userView = new ProjectView('Задачи', 'layout.php');
		$userView->render();
	}
}