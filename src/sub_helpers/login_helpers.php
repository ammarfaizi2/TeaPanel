<?php

use Exceptions\UserException;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @package \Exceptions
 */

if (!function_exists("checkPassword")) {
	/**
	 * @param string $username
	 * @param string $password
	 * @throws \Exceptions\UserException
	 * @return bool
	 */
	function checkPassword(string $username, string $password): bool
	{
		if (!file_exists(PASSWD_FILE)) {
			throw new UserException(
				sprintf("File %s does not exist", PASSWD_FILE)
			);
		}

		if (!is_readable(PASSWD_FILE)) {
			throw new UserException(
				sprintf("File %s is not readable", PASSWD_FILE)
			);
		}

		if (!file_exists(SHADOW_FILE)) {
			throw new UserException(
				sprintf("File %s does not exist", SHADOW_FILE)
			);
		}

		if (!is_readable(SHADOW_FILE)) {
			throw new UserException(
				sprintf("File %s is not readable", SHADOW_FILE)
			);
		}

		$passwd = json_decode(file_get_contents(PASSWD_FILE), true);
		if (!is_array($passwd)) {
			throw new UserException(
				sprintf("Invalid passwd entry on file %s", PASSWD_FILE)
			);
		}

		$shadow = json_decode(file_get_contents(SHADOW_FILE), true);
		if (!is_array($shadow)) {
			throw new UserException(
				sprintf("Invalid shadow entry on file %s", SHADOW_FILE)
			);
		}
		
		if (isset($passwd[$username], $shadow[$username])) {
			return password_verify($password, $shadow[$username]);
		}
		
		return false;
	}
}

if (!function_exists("getPasswd")) {
	/**
	 * @param string $username
	 * @throws \Exceptions\UserException
	 * @return array
	 */
	function getPasswd(string $username): array
	{
		if (!file_exists(PASSWD_FILE)) {
			throw new UserException(
				sprintf("File %s does not exist", PASSWD_FILE)
			);
		}

		if (!is_readable(PASSWD_FILE)) {
			throw new UserException(
				sprintf("File %s is not readable", PASSWD_FILE)
			);
		}

		$passwd = json_decode(file_get_contents(PASSWD_FILE), true);
		if (!is_array($passwd)) {
			throw new UserException(
				sprintf("Invalid passwd entry on file %s", PASSWD_FILE)
			);
		}

		if (isset($passwd[$username])) {
			return $passwd[$username];
		}

		return [];
	}
}