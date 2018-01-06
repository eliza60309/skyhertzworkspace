<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>SkyHertz workspace</title>
<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<!-- Custom styles for this template -->
	<link href="bootstrap/starter-template.css" rel="stylesheet">
	<style>
		body
		{
			padding-top:5rem;
		}
		.starter-template
		{
			padding: 3rem 1.5rem;
			text-align:center;
		}
	</style>
	<?php
		session_start();
	?>
</head>

<!########################################################>


<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="/index.html">SkyHertz</a>
<!--
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExapmleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>aspo
</button>
-->
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active"><a class="nav-link" href="/negevhut/index.html">Negev hut</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Database</a>
					<div class="dropdown-menu" aria-labelledby="dropdown01">
						<a class="dropdown-item" href="/database/logout.php">Logout</a>
						<a class="dropdown-item" href="/database/home.php">Home</a>
						<a class="dropdown-item" href="/database/house.php">My house</a>
						<a class="dropdown-item" href="/database/favorite.php">Favorite</a>
						<a class="dropdown-item" href="/database/admin.php">
						<?php
							if($_SESSION["root"] == 1)echo "Admin";
						?>
						</a>
						<a class="dropdown-item" href="/database/admin2.php">
						<?php
							if($_SESSION["root"] == 1)echo "Admin advanced";
						?>
						</a>
					</div>
				</li>
				<li>
					<a class="nav-link" style="color: #ffffff">
						<?php		
								echo $_SESSION["username"];
						?>
					</a>
				</li>
				<!--
				<li class="nav-item active">
				</li>
				-->
			</ul>
		</div>
	</nav>


	<div class="container" align="center">
						<?php
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
									header("Location: /database/home.php");
									exit();
								}
							}
							if($_SERVER["REQUEST_METHOD"] == "POST")
							{
								if(!empty($_POST["deleteinfo"]))
								{
									$ret = $pdo->prepare("delete from info_list where information = ?");
									$ret->execute(array(str_replace("_", " ", $_POST["deleteinfo"])));
									$ret = $pdo->prepare("delete from information where information = ?");
									$ret->execute(array(str_replace("_", " ", $_POST["deleteinfo"])));
									
								}
								if(!empty($_POST["deletelocation"]))
								{
									$ret = $pdo->prepare("delete from location where location = ?");
									$ret->execute(array($_POST["deletelocation"]));
									$ret = $pdo->prepare("update house set location = \"UNKNOWN\" where location = ?");
									$ret->execute(array($_POST["deletelocation"]));
								}
								if(!empty($_POST["addinformation"]) && !empty($_POST["information"]) && $_POST["information"] != "")
								{
									$ret = $pdo->prepare("select * from info_list where information = ?");
									$ret->execute(array($_POST["information"]));
									if($ret->fetchObject())$i = true;
									else 
									{
										$ret = $pdo->prepare("insert into info_list(information) value (?)");
										$ret->execute(array($_POST["information"]));
									}
								}
								if(!empty($_POST["addlocation"]) && !empty($_POST["location"]) && $_POST["location"] != "")
								{
									$ret = $pdo->prepare("select * from location where location = ?");
									$ret->execute(array($_POST["location"]));
									if($ret->fetchObject())$j = true;
									else 
									{
										$ret = $pdo->prepare("insert into location(location) value (?)");
										$ret->execute(array($_POST["location"]));
									}
								}
							}
						?>
					</h4>
						<form action="/database/admin2.php" method="post">
						<div class="row">
							<div class="col">
							<table class="table" style="height: 40px;">
								<h3>delete information</h3>
								<tbody>
								<tr>
								<?php
									$ret = $pdo->prepare("select * from info_list");
									$ret->execute();
									$cnt = 0;
									while($re = $ret->fetchObject())
									{
										echo "<td><button class=\"btn btn-secondary\" name=\"deleteinfo\" value=\"" . str_replace(" ", "_", $re->information) . "\">" . $re->information . "</button></td>";
										$cnt++;
										if($cnt == 3)
										{
											echo "</tr><tr>";
											$cnt = 0;
										}
									}
									
								?>
								<?php
								?>
								</tr>
								</tbody>
							</table>
							<div class="input-group">
							<span class="input-group-addon">Add information</span>
							<input type="text" class="form-control
							<?php
								if($i == true)echo " is-invalid";
							?>
							" name="information" placeholder="Information">
							<button class="btn btn-secondary" name="addinformation" value="true">Add</button>
							</div>
							</div>
							<div class="col">
							<table class="table" style="height: 40px;">
								<h3>delete location</h3>
								<tbody>
								<tr>
								<?php
									$ret = $pdo->prepare("select * from location");
									$ret->execute();
									$cnt = 0;
									while($re = $ret->fetchObject())
									{
										echo "<td><button class=\"btn btn-secondary\" name=\"deletelocation\" value=\"" . $re->location . "\">" . $re->location . "</button><td>";
										$cnt++;
										if($cnt == 3)
										{
											echo "</tr><tr>";
											$cnt = 0;
										}
									}
									
								?>
								</tr>
								</tbody>
							</table>
							<div class="input-group">
							<span class="input-group-addon">Add location</span>
							<input type="text" class="form-control
							<?php
								if($j == true)echo " is-invalid";
							?>
							" name="location" placeholder="Location">
							<button class="btn btn-secondary" name="addlocation" value="true">Add</button>
							</div>
							</div>
						</form>
					<!--
			</div>
		</div>-->
	</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
</body>
</html>

