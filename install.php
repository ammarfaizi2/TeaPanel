<?php

require __DIR__."/config/init.php";
require BASEPATH."/bootstrap/init.php";
require BASEPATH."/config/install.php";
require BASEPATH."/src/sub_helpers/cli_helpers.php";

chdir(__DIR__);
set_include_path(__DIR__);

if (trim(shell_exec("whoami")) !== "root") {
	printf("You need to run this command as root!\n");
	exit(1);
}

/**
 * @param string $cmd
 * @return void
 */
function icexec($cmd): void
{
	iclog(trim(shell_exec($cmd)));
}

iclog("Linking teapanel config to /etc/nginx/sites-enabled...");
icexec("ln -svf /opt/teapanel/config/teapanel /etc/nginx/sites-enabled");

iclog("Fixing directory permissions...");
shell_exec("chown -R root:root /opt/teapanel");
shell_exec("chmod -R 755 /opt/teapanel");

iclog("Changing /opt/teapanel/storage/users/passwd.json ownership...");
icexec("chown -v root:root /opt/teapanel/storage/users/passwd.json 2>&1");
icexec("chmod -v 755 /opt/teapanel/storage/users/passwd.json 2>&1");

iclog("Changing /opt/teapanel/storage/users/shadow.json ownership...");
icexec("chown -v root:root /opt/teapanel/storage/users/shadow.json 2>&1");
icexec("chmod -v 700 /opt/teapanel/storage/users/shadow.json 2>&1");

iclog("Chaning nginx run user...");
echo trim(shell_exec("sed -i '/^user/c\user root;' /etc/nginx/nginx.conf 2>&1"));

iclog("Chaning nginx worker_connections...");
echo trim(shell_exec("sed -i '/worker_connections/c\\\tworker_connections ".NGINX_WORKER_CONNECTIONS.";' /etc/nginx/nginx.conf 2>&1"));

iclog("Restarting nginx service...");
icexec("/etc/init.d/nginx restart 2>&1");

iclog("Linking teapanel pool.d config to /etc/php/7.2/fpm/pool.d/...");
icexec("ln -svf /opt/teapanel/config/teapanel.conf /etc/php/7.2/fpm/pool.d/teapanel.conf");

iclog("Changing systemd daemon php7.2-fpm.service ExecStart variable...");
echo trim(shell_exec("sed -i \"/^ExecStart/c\\\\ExecStart=\$(cat /lib/systemd/system/php7.2-fpm.service | grep ExecStart | cut -d '=' -f 2) -R\" /lib/systemd/system/php7.2-fpm.service 2>&1"));

iclog("Reloading systemd daemon...");
echo trim(shell_exec("systemctl daemon-reload 2>&1"));

iclog("Restarting php7.2-fpm service...");
icexec("/etc/init.d/php7.2-fpm restart");
