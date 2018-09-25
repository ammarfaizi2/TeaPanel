<?php

require_once __DIR__."/../config/init.php";
require_once BASEPATH."/bootstrap/init.php";
require_once BASEPATH."/bootstrap/web_init.php";

session_destroy();
header("Location: login.php?ref=logout&w=".urlencode(rstr(64)));
