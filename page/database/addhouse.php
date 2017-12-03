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
					<a class="nav-link" style="color: white">
						<?php		
								echo $_SESSION["username"];
						?>
					</a>
				</li>
				<!--
				<li class="nav-item active">
					<a class="nav-link" href="/database/logout.php">Logout</a>	
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="/database/house.php">House management</a>	
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="/database/favorite.php">Favorite</a>	
				</li>
				<li class="nav-item active">
					<a
					class="nav-link" href="/database/admin.php">Admin page</a>	
				</li>-->
			</ul>
		</div>
	</nav>


	<div class="container" align="center">
		<h3>Add house</h3><!--</div>-->
		<h4>
			<?php
				if($_SESSION["Authenticated"] != true)
				{
					header("Location: /database/logout.php");
					exit();
				}
				$dsn = "mysql:host=localhost;dbname=db";
				$pdo = new PDO($dsn, "webuser");
				if(!empty($_POST["cancel"]))
				{
					header("Location: /database/house.php");
					exit();
				}
				if(!empty($_POST["addhouse"]))
				{	
					$ret = $pdo->prepare("insert into house (name, price, location, time, owner_id) values (?, ?, ?, ?, ?)");
					$ret->execute(array($_POST["name"], intval($_POST["price"]), $_POST["location"], $_POST["time"], intval($_SESSION["uid"])));
					$ret = $pdo->prepare("select * from house where name = ? and price = ? and location = ? and time = ? and owner_id = ?");
					$ret->execute(array($_POST["name"], intval($_POST["price"]), $_POST["location"], $_POST["time"], intval($_SESSION["uid"])));
					while($re = $ret->fetchObject())$id = $re->id;
					
					if(!empty($_POST["laundry_facilities"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "laundry facilities"));
					}
					if(!empty($_POST["wifi"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "wifi"));
					}
					if(!empty($_POST["lockers"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "lockers"));
					}
					if(!empty($_POST["kitchen"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "kitchen"));
					}
					if(!empty($_POST["elevator"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "elevator"));
					}
					if(!empty($_POST["no_smoking"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "no smoking"));
					}
					if(!empty($_POST["television"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "television"));
					}
					if(!empty($_POST["breakfast"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "breakfast"));
					}
					if(!empty($_POST["toiletries_provided"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "toiletries provided"));
					}
					if(!empty($_POST["shuttle_service"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array($id, "shuttle service"));
					}
					header("Location: /database/house.php");
					exit();
				}
			?>
		</h4>
		<form action="/database/addhouse.php" method="post">
			<table class="table" style="height: 40px;">
				<div class="form-check form-check-inline">
					<tbody>
						<tr>
							<td><input class="form-check-input active" type="checkbox" name="laundry_facilities" value="true">laundry facilities<br></td>
							<td><input class="form-check-input active" type="checkbox" name="wifi" value="true">wifi<br></td>
							<td><input class="form-check-input active" type="checkbox" name="lockers" value="true">lockers<br></td>
							<td><input class="form-check-input active" type="checkbox" name="kitchen" value="true">kitchen<br></td>
							<td><input class="form-check-input active" type="checkbox" name="elevator" value="true">elevator<br></td>
							<td><input class="form-check-input active" type="checkbox" name="no_smoking" value="true">no smoking<br></td>
							<td><input class="form-check-input active" type="checkbox" name="television" value="true">television<br></td>
							<td><input class="form-check-input active" type="checkbox" name="breakfast" value="true">breakfast<br></td>
							<td><input class="form-check-input active" type="checkbox" name="toiletries_provided" value="true">toiletries provided<br></td>
							<td><input class="form-check-input active" type="checkbox" name="shuttle_service" value="true">shuttle service<br></td>
						</tr>
					</tbody>
				</div>
			</table>
			<table class="table" style="height: 40px;">
				<thead class="thead-light">
					<tr>
						<form>
							<th scope="col"><input type="text" class="form-control" name="name" placeholder="Name"><br></th>
							<th scope="col"><input type="number" class="form-control" name="price" placeholder="Price"><br></th>
							<th scope="col"><input type="text" class="form-control" name="location" placeholder="Location"><br></th>
							<th scope="col"><input type="text" class="form-control" name="time" placeholder="Time"><br></th>
							<th scope="col">
								<div class="btn-group">
									<button type="submit" name="addhouse" value="1" class="btn btn-secondary">Add</button>
									<button type="submit" name="cancel" value="1" class="btn btn-secondary">Cancel</button>
								</div>
								<br><br>
							</th>
						</form>
					</tr>
				</thead>
			</table>
		</form>
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

