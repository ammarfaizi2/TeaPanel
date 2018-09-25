<?php

if (!function_exists("iclog")) {
	/**
	 * @param string $format
	 * @param mixed  ...$parameters
	 * @return void
	 */
	function iclog(string $format, ...$parameters): void
	{
		printf("[%s] %s\n", date("d F Y H:i:s"), sprintf($format, ...$parameters));
	}
}
