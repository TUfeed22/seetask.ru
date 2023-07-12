<?php

namespace app\Core;

class Router
{
    public string $controller;
    public string $action;
    public array $params = [];
    public function __construct(string $url)
    {
        $this->controller = $this->parse($url)['controller'];
        $this->action = $this->parse($url)['action'];
        if (!empty($this->parse($url)['params'])) {
            $this->params = $this->parse($url)['params'];
        }

    }

    /**
     * Парсинг url на отдельные составляющие: controller, action и параметры
     * @param $url
     * @return array
     */
    private function parse($url): array
    {
        $parseUrl = parse_url($url);
        $path = explode('/', $parseUrl['path']);
        array_shift($path);

        $controllerAndActionAndParams = array_combine(['controller', 'action'], $path);
        if (!empty($parseUrl['query'])) {
            parse_str($parseUrl['query'], $params);
            $controllerAndActionAndParams['params'] = $params;
        }

        return $controllerAndActionAndParams;
    }
}