<?php

define("BASEPATH", realpath(__DIR__."/.."));
define("STORAGE_PATH", BASEPATH."/storage");
define("PASSWD_FILE", STORAGE_PATH."/users/passwd.json");
define("SHADOW_FILE", STORAGE_PATH."/users/shadow.json");
