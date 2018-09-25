<?php

require_once __DIR__."/../config/init.php";
require_once BASEPATH."/bootstrap/init.php";
require_once BASEPATH."/bootstrap/web_init.php";
require_once BASEPATH."/";

if (isset($_SESSION["login"])) {
	header("Location: home.php?ref=login.php&w=".urlencode(rstr(32)));
	exit(0);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (
		isset(
			$_SESSION["_token"], 
			$_POST["username"], 
			$_POST["password"], 
			$_POST["_token"], 
			$_POST["login"]
		) &&
		$_POST["login"] === "Login" &&
		$_POST["_token"] === $_SESSION["_token"] &&
		is_string($_POST["username"]) &&
		is_string($_POST["password"])
	) {
		
	}
	header("Location: login.php?ref=login_error&w=".urlencode(rstr(32)));
	exit(0);
}

$token = rstr(64);
$_SESSION["_token"] = $token;

?><!DOCTYPE html>
<html>
<head>
	<title>Tea Panel Login</title>
	<link rel="stylesheet" type="text/css" href="/css/login.css"/>
</head>
<body>
	<center>
		<div class="mcg">
			<h1>Tea Panel Login</h1>
			<form method="post" action="?action=1">
				<div class="incg">
					<div>
						<label>Username</label>
					</div>
					<div>
						<input type="text" name="username"/>
					</div>
				</div>
				<div class="incg">
					<div>
						<label>Password</label>
					</div>
					<div>
						<input type="password" name="password">
					</div>
				</div>
				<div class="incg">
					<div>
						<input type="hidden" name="_token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, "UTF-8"); ?>"/>
						<input type="submit" name="login" value="Login"/>
					</div>
				</div>
			</form>
		</div>
	</center>
</body>
</html>