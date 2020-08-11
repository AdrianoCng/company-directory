<?php

	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr($url["path"], 1);

	$cd_host = $url["host"];
	$cd_port = 3306;
	$cd_socket = "";
	$cd_user = $url["user"];
	$cd_password = $url["pass"];
	$cd_dbname = substr($url["path"], 1);

?>