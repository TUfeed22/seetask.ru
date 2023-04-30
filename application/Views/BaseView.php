<?php

namespace Views;

use Exception;
use Models\User\User;

class BaseView
{
	protected $title;
	protected $content;
	protected $templateLayout;

	/**
	 * @throws Exception
	 */
	protected function generateCSRFToken(): void
	{
		define('LENGTH_RANDOM_BYTES', 35);

		try {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(LENGTH_RANDOM_BYTES));
		} catch (Exception $e) {
			throw new Exception("Произошла ошибка при генерации csrf-токена: " . $e->getMessage());
		}
	}

	/**
	 * Рендеринг элемента на странице
	 * @param $template
	 * @param array $data
	 * @return false|string
	 */
	public function renderContent($template, array $data=[]): bool|string
	{
		$templatePath = $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $template;

		ob_start();

		if (file_exists($templatePath)) {
			extract($data);
			include $templatePath;
			$this->content = ob_get_contents();
		}

		ob_end_clean();

		return $this->content;
	}

	/**
	 * Рендеринг страницы
	 * @throws Exception
	 */
	public function render(): void
	{
		$templatePath = $_SERVER['DOCUMENT_ROOT'] . '/application/templates/' . $this->templateLayout;

		$data['title'] = $this->title;
		$data['content'] = $this->content;
		$data['currentUser'] = (new User())->currentUser();

		if (file_exists($templatePath)) {
			extract($data);
			include $templatePath;
		}
	}

}