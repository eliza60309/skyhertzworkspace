<?php
	session_start();
	if($_SESSION["Authenticated"] != true)
	{
		header("Location: /database/logout.php");
		exit();
	}
	$dsn = "mysql:host=localhost;dbname=db";
	$pdo = new PDO($dsn, "webuser");
	$ret = $pdo->prepare("select * from `account` where username = ?");
	$ret->execute(array($_SESSION["username"]));
	while($re = $ret->fetchObject())
	{
		if($re->root != 1)
		{
			header("Location: /database/user.php");
			exit();
		}
	}

	
	$ret = $pdo->prepare("select * from `account`");
	$ret->execute();
	while($re = $ret->fetchObject())
	{
		if($_POST["option_" . $re->username] == "kill")
		{
			$pdo2 = new PDO($dsn, "webuser");
			$ret2 = $pdo2->prepare("delete from `account` where username = ?");
			$ret2->execute(array($re->username));
		}
		else if($_POST["option_" . $re->username] == "promote")
		{
			$pdo2 = new PDO($dsn, "webuser");
			$ret2 = $pdo2->prepare("update account set root = 1 where username = ?");
			$ret2->execute(array($re->username));
		}
	}



	$pdo = new PDO($dsn, "webuser");
	$ret = $pdo->prepare("select * from `account`");
	$ret->execute();
	if($_POST["username"] == "")$usernameinvalid = true;
	if(strpos($_POST["username"], ' ') !== false)$usernameinvalid = true;
	while($sth = $ret->fetchObject())
	{
		if($sth->username == $_POST["username"])$usernameinvalid = true;
	}
	if($_POST["password"] == "")$passwordinvalid = true;
	if($_POST["name"] == "")$nameinvalid = true;
	if($_POST["email"] == "")$emailinvalid = true;
	if(strpos($_POST["email"], '@') == false)$emailinvalid = true;
	if(strpos($_POST["email"], '.') == false)$emailinvalid = true;
	if($_POST["root"] == true)$i = 1;
	else $i = 0;
	if($usernameinvalid == true || $passwordinvalid == true || $confirmpasswordinvalid == true || $nameinvalid == true || $emailinvalid == true);
	else
	{
		$ret = $pdo->prepare("insert into account (`username`, `passwd`, `name`, `email`, `root`) values (?, ?, ?, ?, ?)");		
		$ret->execute(array($_POST["username"],hash('sha256', $_POST["password"]) ,$_POST["name"], $_POST["email"], $i));
	}
//	$_SESSION["error"] = true;
	header("Location: /database/admin.php");
	exit();
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
