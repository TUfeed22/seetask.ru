<?php

namespace application\Views;

use application\Configuration\Application;
use Exception;

class BaseView
{
	protected $title;
	protected $content;
	protected $templateLayout;
	protected $scriptJS;
	protected $styleCss;

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
	 * @throws Exception
	 */
	public function renderContent($template, array $data=[]): bool|string
	{
		$templatePath = Application::basePath() . '/application/templates/' . $template;
		$this->generateCSRFToken();

		ob_start();

		if (file_exists($templatePath)) {
			extract($data);
			include $templatePath;
			$this->content = ob_get_contents();
		}

		ob_end_clean();

		return $this->content;
	}

	public function publishJS($path=[]): void
	{
		$this->scriptJS = $path;
	}

	public function publishCss($path=[]): void
	{
		$this->styleCss = $path;
	}

	/**
	 * Рендеринг страницы
	 * @throws Exception
	 */
	public function render(): void
	{
		$templatePath = Application::basePath() . '/application/templates/' . $this->templateLayout;

		$data['title'] = $this->title;
		$data['content'] = $this->content;
		$data['scripts'] = $this->scriptJS;
		$data['styles'] = $this->styleCss;

		if (file_exists($templatePath)) {
			extract($data);
			include $templatePath;
		}
	}

}