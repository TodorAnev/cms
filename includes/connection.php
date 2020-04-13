<?php ob_start(); ?>
<?php 

	$dbhost = "localhost";
	$dbuser = "root";
	$db = "cms";

	$conn = new mysqli($dbhost, $dbuser,"",$db) or die("Connection failed");
 ?>