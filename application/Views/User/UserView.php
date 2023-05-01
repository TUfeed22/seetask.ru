<?php

namespace application\Views\User;

use application\Views\BaseView;

class UserView extends BaseView
{
	public function __construct($title, $template)
	{
		$this->title = $title;
		$this->templateLayout = $template;
	}
}