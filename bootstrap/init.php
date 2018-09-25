<?php

if (!defined("INIT")) {
	define("INIT", 1);
	if (!defined("BASEPATH")) {
		printf("BASEPATH is not defined yet!\n");
		exit(1);
	}

	if (!defined("STORAGE_PATH")) {
		printf("STORAGE_PATH is not defined yet!\n");
		exit(1);
	}

	/**
	 * @param string $class
	 * @return void
	 */
	function iceteaInternalAutoloader(string $class): void
	{
		$class = str_replace("\\", "/", $class);
		if (file_exists($f = BASEPATH."/src/classes/".$class.".php")) {
			require $f;
		}
	}

	require BASEPATH."/src/helpers.php";
}
