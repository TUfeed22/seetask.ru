<?php

namespace application\Models\Project;

use application\Models\BaseModel;
use application\Models\DataMapper;
use application\Models\Project\ProjectStatus;
use application\Models\User\DataMapperUser;
use application\Models\User\User;
use Exception;

/**
 * @property int $id Идентификатор
 * @property string $name Наименование проекта
 * @property string $description Описание проекта
 * @property string $status Статус проекта
 * @property string $createDateTime Дата и время создания проекта
 * @property User $userid Автор/создатель проекта
 */

class Project extends BaseModel
{

	/**
	 * @return string
	 */
	public function getUserid(): string
	{
		return $this->userid;
	}

	/**
	 * @param string $userid
	 * @throws Exception
	 */
	public function setUserid(string $userid): void
	{
		$user = new User();
		$dataMapper = new DataMapperUser();
		$author = $dataMapper->getById($userid);
		$this->userid = $author;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	protected function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * Название проекта
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	protected function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	protected function setDescription(string $description): void
	{
		$this->description = $description;
	}

	/**
	 * @param string $status
	 */
	protected function setStatus(string $status): void
	{
		$enumProjectStatus = ucfirst($status);
		$status = constant("application\Models\Project\ProjectStatus::{$enumProjectStatus}");
		$this->status = $status->label();

	}

	/**
	 * @return string
	 */
	public function getStatus(): string
	{
		return $this->status;
	}

	/**
	 * @param string $createDateTime
	 */
	protected function setCreateDateTime(string $createDateTime): void
	{
		$this->createDateTime = $createDateTime;
	}

	/**
	 * @return string
	 */
	public function getCreateDateTime(): string
	{
		return $this->createDateTime;
	}

	/**
	 * @return string
	 */
	public function getAuthor(): string
	{
		return $this->author;
	}

	/**
	 * @param string $userId
	 */
	protected function setAuthor(string $author): void
	{
		$this->author = $author;
	}

	/**
	 * Наименование таблицы
	 * @return string
	 */
	public static function getTableName(): string
	{
		return 'projects';
	}

	/**
	 * @throws Exception
	 */
	public function columnsDataTable()
	{
		return array(
			'#' => $this->id,
			'Наименование' => $this->name,
			'Описание' => $this->description,
			'Кол-во задач' => '0',
			'Дата создания' => $this->createDateTime,
			'Автор' => $this->author,
			'Статус' => $this->status,
		);
	}

	/**
	 * @throws Exception
	 */
	public function getProjectsAll()
	{
		$dataMapper = new DataMapperProject();
		return $dataMapper->getRecordsAsObjects($this->getTableName());
	}
}