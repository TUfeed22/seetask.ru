<?php

namespace Views\User;

use Views\BaseView;

class UserView extends BaseView
{
	public function __construct($title, $template)
	{
		$this->title = $title;
		$this->templateLayout = $template;
	}
}