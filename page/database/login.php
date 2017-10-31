<?php
	session_start();
//	if($_SESSION["Authenticated"])
//	{
	$_SESSION["username"] = $_POST["username"];
		//echo $_POST['username'];
		//echo $_POST['password'];
//	}
	$_SESSION["Authenticated"] = true;
//	else echo "false";
?>
