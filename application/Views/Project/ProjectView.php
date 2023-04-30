<?php

namespace Views\Project;

use Views\BaseView;

class ProjectView extends BaseView
{
	public function __construct($title, $template)
	{
		$this->title = $title;
		$this->templateLayout = $template;
	}
}