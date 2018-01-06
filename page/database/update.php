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
		<h3>Update</h3><!--</div>-->
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
				$location_exist = false;
				if(!empty($_POST["update"]))
				{
					$ret = $pdo->prepare("select * from location");
					$ret->execute();
					while($re = $ret->fetchObject())
					{
						if($_POST["location"] == $re->location)$location_exist = true;
					}
				}
				if($location_exist == false);//echo "location doesn't exist";
				else if(!empty($_POST["update"]))
				{	
					$ret = $pdo->prepare("delete from information where house_id = ?");
					$ret->execute(array(intval($_SESSION["Update"])));
					
					$ret = $pdo->prepare("select * from info_list");
					$ret->execute();
					while($re = $ret->fetchObject())
					{
						if(!empty($_POST[str_replace(" ", "_", $re->information)]))
						{
							$ret2 = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
							$ret2->execute(array(intval($_SESSION["Update"]), $re->information));
						}
					}/*
					if(!empty($_POST["laundry_facilities"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "laundry facilities"));
					}
					if(!empty($_POST["wifi"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "wifi"));
					}
					if(!empty($_POST["lockers"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "lockers"));
					}
					if(!empty($_POST["kitchen"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "kitchen"));
					}
					if(!empty($_POST["elevator"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "elevator"));
					}
					if(!empty($_POST["no_smoking"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "no smoking"));
					}
					if(!empty($_POST["television"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "television"));
					}
					if(!empty($_POST["breakfast"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "breakfast"));
					}
					if(!empty($_POST["toiletries_provided"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "toiletries provided"));
					}
					if(!empty($_POST["shuttle_service"]))
					{
						$ret = $pdo->prepare("insert into information (house_id, information) values (?, ?)");
						$ret->execute(array(intval($_SESSION["Update"]), "shuttle service"));
					}*/
					$ret = $pdo->prepare("update house set name = ?, price = ?, location = ?, time = ? where id = ?");
					$ret->execute(array($_POST["name"], intval($_POST["price"]), $_POST["location"], $_POST["time"], intval($_SESSION["Update"])));
					header("Location: /database/house.php");
					exit();
				}
				$ret = $pdo->prepare("select * from house where id = ? and owner_id = ?");
				$ret->execute(array(intval($_SESSION["Update"]), intval($_SESSION["uid"])));
				while($re = $ret->fetchObject())
				{
					$id = $re->id;
					$name = $re->name;
					$price = $re->price;
					$location = $re->location;
					$time = $re->time;
				}
				$ret = $pdo->prepare("select * from information where house_id = " . $id);
				$ret->execute();
				$ret2 = $pdo->prepare("select * from info_list");
				$ret2->execute();
				$flags = array();
				while($re2 = $ret2->fetchObject())$flags[$re2->information] = !empty($_POST[str_replace(" ", "_", $re2->information)]);
				//$flags = array("laundry facilities" => 0,"wifi" => 0, "lockers" => 0, "kitchen" => 0, "elevator" => 0, "no smoking" => 0, "television" => 0, "breakfast" => 0, "toiletries provided" => 0, "shuttle service" => 0);
				while($re = $ret->fetchObject())
				{
					$flags[$re->information] = 1;
				}
			?>
		</h4>
		<form action="/database/update.php" method="post">
			<table class="table" style="height: 40px;">
				<div class="form-check form-check-inline">
					<tbody>
						<tr>
							<?php
								$ret = $pdo->prepare("select * from info_list");
								$ret->execute();
								while($re = $ret->fetchObject())
								{
									echo "<td><input class=\"form-check-input active\"";
									if($flags[$re->information] == 1)echo "checked ";
									echo "type=\"checkbox\" name=\"";
									echo str_replace(" ", "_", $re->information);
									echo "\" value=\"true\">";
									echo $re->information;
									echo "<br></td>";

								}
							?>
						</tr>
					</tbody>
				</div>
			</table>
			<table class="table" style="height: 40px;">
				<thead class="thead-light">
					<tr>
						<form>
							<th scope="col">
								ID<br>
								<input type="text" class="form-control" name="search_id" placeholder="ID"
								<?php
									echo "value=\"" . $id . "\"";
								?>
								readonly>
							</th>
							<th scope="col">
								Name<br>
								<input type="text" class="form-control" name="name" placeholder="Name"
								<?php
									echo "value=\"" . $name . "\"";
								?>
								>
								
							</th>
							<th scope="col">
								Price<br>
								<input type="number" class="form-control" name="price" placeholder="Price"
								<?php
									echo "value=\"" . $price . "\"";
								?>
								>
							</th>
							<th scope="col">
								Location<br>
								<input type="text" class="form-control 
								<?php
									if(!empty($_POST["update"]) && $location_exist == false)echo " is-invalid";
								?>
								" name="location" placeholder="Location"
								<?php
									echo "value=\"" . $location . "\"";
								?>
								>
							</th>
							<th scope="col">
								Time<br>
								<input type="text" class="form-control" name="time" placeholder="Time"
								<?php
									echo "value=\"" . $time . "\"";
								?>
								>
							</th>
							<!--
							<th scope="col">
								Owner<br>
								<input type="text" class="form-control" name="owner" placeholder="Owner"
								<?php
					//				echo "value=\"" . $owner . "\"";
								?>
								readonly>
							</th>
							-->
							<th scope="col">
								<div class="btn-group">
									<button type="submit" name="update" value="1" class="btn btn-secondary">Update</button>
									<button type="submit" name="cancel" value="1" class="btn btn-secondary">Cancel</button>
								</div>
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

