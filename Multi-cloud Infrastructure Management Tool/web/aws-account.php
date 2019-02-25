<?php

if (preg_match('/^([a-zA-Z0-9._-]+)$/', $_GET["account"], $tmp))
	$account = $tmp[1];
else
	die("Missing arguments...");

$file = "/var/cache/polynimbus/inventory/users-aws-$account.list";

if (!file_exists($file))
	die("Invalid account...");

$date = date("Y-m-d H:i:s", filemtime($file));
$data = file_get_contents($file);
$lines = explode("\n", $data);

require "include/page.php";
page_header("Polynimbus - AWS account details");
echo "AWS account <strong>$account</strong> user list as of $date:<br />\n";
table_start("users", array("username", "created"));

foreach ($lines as $line) {
	$line = trim($line);
	if (empty($line))
		continue;

	$tmp = explode(" ", $line);
	$username = $tmp[0];
	$created = $tmp[1];

	table_row(array($username, $created));
}

table_end("users");
page_end();
