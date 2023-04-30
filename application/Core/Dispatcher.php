<?php
namespace Core;

use Controllers;
class Dispatcher
{
  private $controller;

  public function __construct($controller)
  {
    $this->controller = $controller;
  }

  /**
   * Определение контроллера
   * @return void
   */
  public function getController(): void
  {
    $controllerName = ucfirst($this->controller->name) . 'Controller';

    if ($this->controller->params) {
      call_user_func(array(new $controllerName, $this->controller->action), $this->controller->params);
    } else {
      call_user_func(array(new $controllerName, $this->controller->action));
    }
  }
}