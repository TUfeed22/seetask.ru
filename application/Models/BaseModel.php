<?php

namespace application\Models;

class BaseModel
{
	/**
	 * Магическим образом получаем имя неопределенного свойства, возвращаем соответствующий ему метод get
	 * @param string $property
	 * @return void
	 */
	public function __get(string $property)
	{
		$method = "get{$property}";

		if (method_exists($this, $method)) {
			return $this->$method();
		}
	}

	/**
	 * Магическим образом получаем имя неопределенного свойства,
	 * передаем значение $value и возвращаем соответствующий ему метод set
	 * @param string $property
	 * @param mixed $value
	 * @return void
	 */
	public function __set(string $property, mixed $value)
	{
		$method = "set{$property}";

		if (method_exists($this, $method)) {
			$this->$method($value);
		}
	}
}