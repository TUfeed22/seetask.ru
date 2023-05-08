<?php

namespace application\Components;

use application\Configuration\Application;

class DataTableComponent
{
	private $objects;
	private $content;

	public function __construct($objects)
	{
		$this->objects = $objects;
	}

	public function render()
	{
		$templatePath = Application::basePath() . '/application/templates/components/table.php';
		$data['projects'] = $this->objects;

		ob_start();

		if (file_exists($templatePath)) {
			extract($data);
			include $templatePath;
			$this->content = ob_get_contents();
		}

		ob_end_clean();
		return $this->content;
	}

}