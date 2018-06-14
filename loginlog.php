<?php

$plugins->add_hook("datahandler_login_validate_end", "loginlog_log");

if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.");
}

function loginlog_install() {

	global $db, $mybb;

	$setting_group = array(
		"name"        => "loginlog",
		"title"       => "loginlog",
		"description" => "This section allows you to change the settings of the loginlog plugin.",
		"disporder"   => 30,
		"isdefault"   => 1
	);

	$gid = $db->insert_query("settinggroups", $setting_group);

	$setting_array = array(

		"loginlog_location" => array(
			"title"       => "loginlog Location",
			"description" => "Enter the filesystem location (path) for the loginlog.",
			"optionscode" => "text",
			"value"       => "/var/log/mybb/auth.log",
			"disporder"   => 1
		),

		"loginlog_user" => array(
			"title"       => "Log success user auth?",
			"description" => "Should success authentication requests in the user interface get logged, too?",
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

function loginlog_uninstall() {

	global $db;

	$db->delete_query("settings", "name IN ('loginlog_location','loginlog_user')");
	$db->delete_query("settinggroups", "name = 'loginlog'");

	rebuild_settings();

}

function loginlog_is_installed() {

	global $mybb;
	return isset($mybb->settings["loginlog_location"]);

}

function loginlog_info() {
	return array(
		"name"          => "loginlog",
		"description"   => "Logging of authentication requests.",
		"website"       => "",
		"author"        => "Jonas Wolff",
		"authorsite"    => "",
		"version"       => "1.0",
		"guid"          => "",
		"codename"      => "loginlog",
		"compatibility" => "18*"
	);
}

function loginlog_log($auth) {

	if (count($auth->get_errors()) > 0) {
		return;
	}

	global $mybb;
	$logline = "mybb: login for user " . rawurlencode($auth->data["username"]) . " with ip " . $_SERVER["REMOTE_ADDR"] . " in ";

	if (defined("IN_ADMINCP")) {
		loginlog_log_line($logline . "admin cp");
	} elseif ($mybb->settings["loginlog_user"] == 1) {
		loginlog_log_line($logline . "user cp");
	}

}

function loginlog_log_line($logline) {

	global $mybb;
	$logfile = $mybb->settings["loginlog_location"];
	$hostname = gethostname();
	$date = exec("date +%b\ %d\ %H:%M:%S");
	file_put_contents($logfile, $date . " " . $hostname . " " . $logline . "\n", FILE_APPEND);

}

?>
