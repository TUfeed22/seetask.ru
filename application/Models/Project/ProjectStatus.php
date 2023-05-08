<?php

namespace application\Models\Project;

/**
 * Статусы проекта
 */
enum ProjectStatus: string
{
	case New = 'new';
	case Close = 'close';
	case Active = 'active';
	case Suspended = 'suspended';

	/**
	 * Возвращает читаемую строку на кириллице
	 * @return string
	 */
	public function label(): string
	{
		return match ($this) {
			ProjectStatus::New => 'Новый',
			ProjectStatus::Close => 'Закрытый',
			ProjectStatus::Active => 'Активный',
			ProjectStatus::Suspended => 'Приостановленный',
		};
	}
}
