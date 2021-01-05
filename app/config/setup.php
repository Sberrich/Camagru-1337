<?php

		$DB_HOST = DB_HOST;
		$DB_USER = DB_USER;
		$DB_PASS = DB_PASS;
		$DB_NAME = DB_NAME;
		$DB_DSN = "mysql:host=$DB_HOST";
		try
		{
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			$stmt = $db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$DB_NAME'");
			if(!$stmt->fetch())
			{
				$sql = "CREATE DATABASE IF NOT EXISTS `" . $DB_NAME . "`;"; 
				$db->exec($sql);
		
				
				$db->exec('use ' . $DB_NAME . ';');
			
				
				$sql = file_get_contents(APPROOT.'/config/camagru.sql');
				$db->exec($sql);
			
			}
		}
		catch (PDOException $e)
		{
			echo 'Error: ' . $e->getMessage() . '\n';
			die();
		}
