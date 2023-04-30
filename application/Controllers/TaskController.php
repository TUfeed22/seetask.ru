<?php

namespace Controllers;

use Exception;
use Views\Project\ProjectView;

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