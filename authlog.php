<?php

$plugins->add_hook("datahandler_login_validate_end", "authlog_log");

if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.");
}

function authlog_install() {

	global $db, $mybb;

	$setting_group = array(
		"name"        => "authlog",
		"title"       => "AuthLog",
		"description" => "This section allows you to change the settings of the AuthLog plugin.",
		"disporder"   => 30,
		"isdefault"   => 1
	);

	$gid = $db->insert_query("settinggroups", $setting_group);

	$setting_array = array(

		"authlog_location" => array(
			"title"       => "AuthLog Location",
			"description" => "Enter the filesystem location (path) for the AuthLog.",
			"optionscode" => "text",
			"value"       => "/var/log/mybb/auth.log",
			"disporder"   => 1
		),

		"authlog_user" => array(
			"title"       => "Log failed user auth?",
			"description" => "Should failed authentication requests in the user interface get logged, too?",
			"optionscode" => "yesno",
			"value"       => 1,
			"disporder"   => 2
		)

	);

	foreach($setting_array as $name => $setting) {
		$setting["name"] = $name;
		$setting["gid"] = $gid;

		$db->insert_query("settings", $setting);
	}

	rebuild_settings();

}

function authlog_uninstall() {

	global $db;

	$db->delete_query("settings", "name IN ('authlog_location','authlog_user')");
	$db->delete_query("settinggroups", "name = 'authlog'");

	rebuild_settings();

}

function authlog_is_installed() {

	global $mybb;
	return isset($mybb->settings["authlog_location"]);

}

function authlog_info() {
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

function authlog_log($auth) {

	if (count($auth->get_errors()) < 1) {
		return;
	}

	global $mybb;
	$logline = "mybb: login failure for user " . $auth->data["username"] . " with ip " . $_SERVER["REMOTE_ADDR"] . " in ";

	if (defined("IN_ADMINCP")) {
		authlog_log_line($logline . "admin cp");
	} elseif ($mybb->settings["authlog_user"] == 1) {
		authlog_log_line($logline . "user cp");
	}

}

function authlog_log_line($logline) {

	global $mybb;
	$logfile = $mybb->settings["authlog_location"];
	$hostname = gethostname();
	$date = exec("date +%b\ %d\ %H:%M:%S");
	file_put_contents($logfile, $date . " " . $hostname . " " . $logline . "\n", FILE_APPEND);

}

?>
