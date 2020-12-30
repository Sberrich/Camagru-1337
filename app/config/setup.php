<?php
class Setup extends Controller
{
	public function index()
	{
		try {
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			$dsn = 'mysql:host=' . DB_HOST . ';';
			$cn = new PDO($dsn, DB_USER, DB_PASS, $options);
			$sql = "DROP DATABASE IF EXISTS " . DB_NAME . ";";
			$cn->exec($sql);
			$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . ";";
			$cn->exec($sql);
			$cn->exec('use ' . DB_NAME . ';');
			$sql = file_get_contents(__DIR__.'/../config/camagru.sql');
			$cn->exec($sql);
			flash("setup_success","Database schema imported ,OK -> Ready to roll !","alert alert-warning");
			redirect("pages/setup");
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '\n';
			die();
		}
	}
}
?>