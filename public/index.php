<?php

require __DIR__."/../config/init.php";
require BASEPATH."/bootstrap/init.php";
require BASEPATH."/bootstrap/web_init.php";

if (isset($_SESSION["login"])) {
	require __DIR__."/home.php";
} else {
	require __DIR__."/login.php";
}
