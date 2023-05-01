<?php

namespace application\Controllers;

use Exception;
use application\Views\Project\ProjectView;

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