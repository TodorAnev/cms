<?php session_start(); ?>
<?php ob_start(); ?>
<?php 
		$_SESSION['username'] = null;
		$_SESSION['u_f_name'] = null;
		$_SESSION['u_l_name'] = null;
		$_SESSION['u_role'] = null;
		header("Location: ../index.php");