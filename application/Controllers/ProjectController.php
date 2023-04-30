<?php

namespace Controllers;

use Exception;
use Views\Project\ProjectView;

class ProjectController extends BaseController
{
	/**
	 * Страница Проекты
	 * @throws Exception
	 */
	public function index(): void
	{
		$this->isCurrentUserLoggedIn();

		$userView = new ProjectView('Проекты', 'layout.php');
		$userView->render();
	}
}