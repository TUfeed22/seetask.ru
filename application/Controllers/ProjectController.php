<?php

namespace application\Controllers;

use application\Components\DataTableComponent;
use application\Models\Project\DataMapperProject;
use application\Models\Project\Project;
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
		$project = new Project();
		$dataMapper = new DataMapperProject();
		$table = new DataTableComponent($dataMapper->getRecordsAsObjects($project));
		$userView->renderContent('admin/project/index.php', ['table' => $table->render()]);
		$userView->render();
	}
}