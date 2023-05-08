<?php
namespace application\Models\User;
use application\Models\BaseModel;
use application\Models\Project\DataMapperProject;
use Exception;

/**
 * Класс пользователя
 *
 * @property int $id Id пользователя
 * @property string $email Адрес электронной почты пользователя
 * @property string $login Логин пользователя
 * @property string $lastname Фамилия пользователя
 * @property string $firstname Имя пользователя
 * @property string $city Город пользователя
 * @property string $password Пароль пользователя
 */
class User extends BaseModel
{

	public function __toString()
	{
		if ($this->lastname && $this->firstname) {
			return $this->firstname . " " . $this->lastname;
		} else {
			return $this->login;
		}
	}

	/**
	 * Возвращает id пользователя
	 * @return int
	 */
	private function getId(): int
	{
		return $this->id;
	}

	/**
	 * Возвращает email пользователя
	 * @return string
	 */
	private function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * Возвращает login пользователя
	 * @return string
	 */
	private function getLogin(): string
	{
		return $this->login;
	}

	/**
	 * Пароль пользователя
	 *
	 * @return string
	 */
	private function getPassword(): string
	{
		return $this->password;
	}

	protected function setPassword(string $password): void
	{
		$this->password = $password;
	}

	/**
	 *
	 * @param string $email
	 */
	protected function setEmail(string $email): void
	{
		$this->email = $email;
	}

	/**
	 * @param string $login
	 */
	protected function setLogin(string $login): void
	{
		$this->login = $login;
	}

	/**
	 * @param int $id
	 */
	protected function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	private function getCity(): string
	{
		return $this->city;
	}

	/**
	 * @return string
	 */
	private function getFirstname(): string
	{
		return $this->firstname;
	}

	/**
	 * @return string
	 */
	private function getLastname(): string
	{
		return $this->lastname;
	}

	/**
	 * @param mixed $city
	 */
	protected function setCity(?string $city): void
	{
		$this->city = $city;
	}

	/**
	 *
	 * @param mixed $firstname
	 */
	protected function setFirstname(?string $firstname): void
	{
		$this->firstname = $firstname;
	}

	/**
	 *
	 * @param mixed $lastname
	 */
	protected function setLastname(?string $lastname): void
	{
		$this->lastname = $lastname;
	}

	/**
	 * Текущий пользователь
	 *
	 * @return User Модель пользователя
	 * @throws Exception
	 */
	public function currentUser(): User
	{
		$mapperUser = new DataMapperUser();
		return $mapperUser->getById($_SESSION['user_id']);
	}

	/**
	 * Наименование таблицы
	 * @return string
	 */
	public static function getTableName(): string
	{
		return 'users';
	}

	/**
	 * @throws Exception
	 */
	public function getUsersAll()
	{
		$dataMapper = new DataMapperProject();
		return $dataMapper->getRecordsAsObjects($this->getTableName());
	}
}