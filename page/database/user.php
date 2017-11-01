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
						<a class="dropdown-item" href="/database/index.php">Login page</a>
						<a class="dropdown-item" href="/database/signup.php">Sign up</a>
	
					</div>
				</li>
				<li>
					<a class="nav-link" style="color: #ffffff">
						<?php		
								echo $_SESSION["username"];
						?>
					</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="/database/logout.php">Logout</a>	
				</li>
			</ul>
		</div>
	</nav>


	<div class="container" align="center">
		<div class="card"  style="width: 30rem;">
			<div class="card-body">
				<div class="card-title"><h3>User information</h3></div>
					<h4>
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
								if($re->root == 1)
								{
									header("Location: /database/admin.php");
									exit();
								}
								?>
								<table class="table">
									<tbody>
									<tr><td>Name</td><td>
								<?php
									echo $re->name;
								?></td></tr>
									<tr><td>Username</td><td>
								<?php
									echo $re->username;
								?></td></tr>
									<tr><td>Email</td><td>
								<?php
								echo $re->email;
							}
						?></td></tr>
									</tbody>
								</table>
					</h4>
			</div>
		</div>
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

