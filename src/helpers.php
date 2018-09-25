<?php

if (!function_exists("rstr")) {
	/**
	 * @param int    $n
	 * @param string $e
	 * @return string
	 */
	function rstr($n, $e = null): string
	{
		if (is_null($e)) {
			$e = "1234567890qwertyuiopasdfghjklzxcvbnnmQWERTYUIOPASDFGHJKKLZXCVBNM___---...";
		}
		$r = "";
		$c = strlen($e) - 1;
		$n = abs($n);
		for ($i=0; $i < $n; $i++) { 
			$r .= $e[rand(0, $c)];
		}
		return $r;
	}
}
