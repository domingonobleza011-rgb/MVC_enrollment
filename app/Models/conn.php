<?php
	
 
	$cfg = require __DIR__ . '/../../config.php';
	$conn = new PDO($cfg['db_dsn'], $cfg['db_user'], $cfg['db_pass']);
	if(!$conn){
		die("Error: Failed to connect to database!");
	}

?>