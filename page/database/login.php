<?php
	session_start();
	$dsn = "mysql:host=localhost;dbname=db";
	$pdo = new PDO($dsn, "webuser");
	$ret = $pdo->prepare("select * from `account` where username = ?");
	
	$ret->execute(array($_POST["username"]));
	while($re = $ret->fetchObject())
	{
		if($re->passwd == hash('sha256', $_POST["password"]))
		{
			$_SESSION["username"] = $_POST["username"];
			if($re->root == 1)
			{
				header("Location: ./admin.php");
				exit();
			}
			else
			{
				header("Location: ./user.php");
				exit();
			}
		}
		else echo "false";
	}
/*	if($_SESSION["submit"] == true)
	{
		if($_POST["username"] == "")$usernameinvalid = true;
		if(strpos($_POST["username"], ' ') !== false)$usernameinvalid = true;
		while($sth = $ret->fetchObject())
		{
			if($sth->account == $_POST["username"])$usernameinvalid = true;
		}
		if($_POST["password"] == "")$passwordinvalid = true;
						if($usernameinvalid == true || $passwordinvalid == true || $confirmpasswordinvalid == true || $nameinvalid == true || $emailinvalid == true);
						else
						{
							$ret = $pdo->prepare("insert into account (`username`, `passwd`, `name`, `email`, `root`) values (?, ?, ?, ?, 0)");		
							$ret->execute(array($_POST["username"],hash('sha256', $_POST["password"]) ,$_POST["name"], $_POST["email"]));
							session_unset();
							session_destroy();
							header("Location: ./index.php");
							exit();	
						}
					}
					
					
				?>
//	if($_SESSION["Authenticated"])
//	{
//	$_SESSION["username"] = $_POST["username"];
		//echo $_POST['username'];
		//echo $_POST['password'];
//	}
//	$_SESSION["Authenticated"] = true;
//	else echo "false";*/
?>
