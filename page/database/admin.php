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
	<!--
		<div class="card" align="center" style="width: 30rem;">
			<div class="card-body">
				<div class="card-title">--><h3>User information</h3><!--</div>-->
					<h4>
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
									header("Location: /database/user.php");
									exit();
								}
							}
						?>
					</h4>
						<form action="/database/action.php" method="post">
							<table class="table" style="height: 40px;">
								<thead class="thead-light">
									<tr>
										<th scope="col">Account</th>
										<th scope="col">Name</th>
										<th scope="col">Email</th>
										<th scope="col">Authority</th>
										<th scope="col">Operation</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$ret = $pdo->prepare("select * from `account`");
									$ret->execute();
									while($re = $ret->fetchObject())
									{
										echo "<tr>";
										echo "<td>" . $re->username . "</td>\n";
										echo "<td>" . $re->name . "</td>\n";
										echo "<td>" . $re->email . "</td>\n";
										if($re->username == $_SESSION["username"])echo "<td>Admin</td><td></td>\n";
										else if($re->root == 1)
										{
											echo "<td>Admin</td>\n";
											echo "<td><select class=\"form-control\" style=\"width:7rem\" name=\"option_" . $re->username . "\">\n";
											echo "<option selected>None</option>\n";
											echo "<option value=\"kill\">Kill</option></select></td>\n";
										}
										else
										{
											echo "<td>User</td>\n";
											echo "<td><select class=\"form-control\" style=\"width:7rem\" name=\"option_" . $re->username . "\">\n";
											echo "<option selected>None</option>\n";
											echo "<option value=\"promote\">Promote</option>\n";
											echo "<option value=\"kill\">Kill</option></select></td>\n";
										}
										echo "</tr>";
									}
								?>
								</tbody>
							</table>
							<div class="input-group">
							<span class="input-group-addon">Add user</span>
							<input type="text" class="form-control" name="username" placeholder="Username">
							<input type="password" class="form-control" name="password" placeholder="Password">
							<input type="text" class="form-control" name="email" placeholder="Email">
							<input type="text" class="form-control" name="name" placeholder="name">
							<span class="input-group-addon">
							<input type="checkbox" name="root">&nbsp;&nbsp;Admin</input></span>&nbsp;&nbsp;
							<button class="btn btn-secondary" action="">Operate</button>
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

