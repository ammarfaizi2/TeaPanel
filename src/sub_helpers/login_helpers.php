<?php

use Exceptions\UserException;

if (!function_exists("checkPassword")) {
	/**
	 * @param string $username
	 * @param string $password
	 * @throws \Exceptions\UserException
	 * @return bool
	 */
	function checkPassword(string $username, string $password): bool
	{
		$passwdFile = STORAGE_PATH."/users/passwd.json";
		$shadowFile = STORAGE_PATH."/users/shadow.json";

		if (!file_exists($passwdFile)) {
			throw new UserException(
				sprintf("File %s does not exist", $passwdFile)
			);
		}

		if (!is_readable($passwdFile)) {
			throw new UserException(
				sprintf("File %s is not readable", $passwdFile)
			);
		}

		if (!file_exists($shadowFile)) {
			throw new UserException(
				sprintf("File %s does not exist", $shadowFile)
			);
		}

		if (!is_readable($shadowFile)) {
			throw new UserException(
				sprintf("File %s is not readable", $shadowFile)
			);
		}

		$passwd = json_decode(file_get_contents($passwdFile), true);
		if (!is_array($passwd)) {
			throw new UserException(
				sprintf("Invalid passwd entry on file %s", $passwdFile)
			);
		}

		$shadow = json_decode(file_get_contents($shadowFile), true);
		if (!is_array($shadow)) {
			throw new UserException(
				sprintf("Invalid shadow entry on file %s", $shadowFile)
			);
		}

		if (isset($passwd[$username]) && isset($shadow[$username])) {
			return password_verify($password, $shadow[$username]);
		}
		
		return false;
	}
}
