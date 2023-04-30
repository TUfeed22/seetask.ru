<?php
namespace Controllers\Tool;
class Tool
{
  /**
   * Проверка csrf-токена
   *
   * @param $token
   * @return bool
   */
  public static function checkCsrfToken($token): bool
  {
    if (!$token || $token !== $_SESSION['csrf_token']) {
      return false;
		}
		return true;
  }
}