<?php

namespace Models\Project;

/**
 * @property $id Идентификатор
 * @property $name Наименование проекта
 * @property $description Описание проекта
 * @property $author Автор/создатель проекта
 */

class Project
{

	/**
	 * Наименование таблицы
	 * @return string
	 */
	public static function getTableName(): string
	{
		return 'project';
	}
}