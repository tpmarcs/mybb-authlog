<?php

$plugins->add_hook("datahandler_login_validate_end", "authlog_log_user");

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.");
}

function authlog_info()
{
	return array(
		"name"          => "AuthLog",
		"description"   => "Logging of authentication requests.",
		"website"       => "",
		"author"        => "Jonas Wolff",
		"authorsite"    => "",
		"version"       => "1.0",
		"guid"          => "",
		"codename"      => "authlog",
		"compatibility" => "18*"
	);
}

function authlog_log_user($auth) {

	if (!defined("IN_ADMINCP") || count($auth->get_errors()) < 1) {
		return;
	}

	$logline = "mybb: login failure for user " . $auth->data["username"] . " with ip " . $_SERVER["REMOTE_ADDR"];
	$logfile = "/var/log/mybb/auth.log";
	$hostname = gethostname();
	$date = exec("date +%b\ %d\ %H:%M:%S");
	file_put_contents($logfile, $date . " " . $hostname . " " . $logline . "\n", FILE_APPEND);

}

?>
