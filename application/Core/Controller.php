<?php
namespace application\Core;
class Controller
{
  private $name;
  private $action;
  private $params;
	private $namespace = 'application\\Controllers\\';

  public function __construct($name, $action, $params = null)
  {
    $this->name = $this->namespace . $name;
    $this->action = $action;
    $this->params = $params;
  }

  public function __get($property)
  {
    return $this->$property;
  }
}