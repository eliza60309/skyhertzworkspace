<?php
	session_start();
	$dsn = "mysql:host=localhost;dbname=db";
	$secret = "6LeifD4UAAAAALCF0Acfjk3yvSd6H85Hh1zA8Q1V";
	if(empty($_POST["g-recaptcha-response"]))
	{
		$_SESSION["recap"] = "failed";
		header("Location: /database/index.php");
		exit();
	}
						
	$pdo = new PDO($dsn, "webuser");
	$ret = $pdo->prepare("select * from `account` where username = ?");
	
	$ret->execute(array($_POST["username"]));
	while($re = $ret->fetchObject())
	{
		if($re->passwd == hash('sha256', $_POST["password"]))
		{
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["uid"] = $re->id;
			$_SESSION["root"] = $re->root;
/*			if($re->root == 1)
			{
				$_SESSION["Authenticated"] = true;
				header("Location: /database/admin.php");
				exit();
			}
			else
			{
				$_SESSION["Authenticated"] = true;
				header("Location: /database/user.php");
				exit();
			}*/
			$_SESSION["Authenticated"] = true;
			header("Location: /database/home.php");
			exit();
		}
		//else echo "false";
	}
	$_SESSION["error"] = true;
	header("Location: /database/index.php");
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
