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
				$ret = $pdo->prepare("select * from house where id = ? and owner_id = ?");
				$ret->execute(array(intval($_SESSION["Update"]), intval($_SESSION["uid"])));
				while($re = $ret->fetchObject())
				{
					$name = $re->name;
					$price = $re->price;
					$location = $re->location;
					$time = $re->time;
				}
			?>
		</h4>
		<form action="/database/home.php" method="post">
			<table class="table" style="height: 40px;">
				<div class="form-check form-check-inline">
					<tbody>
						<tr>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["laundry_facilities"]))echo "checked";
							?>
							type="checkbox" name="laundry_facilities" value="true">laundry facilities<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["wifi"]))echo "checked";
							?>
							type="checkbox" name="wifi" value="true">wifi<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["lockers"]))echo "checked";
							?>
							type="checkbox" name="lockers" value="true">lockers<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["kitchen"]))echo "checked";
							?>
							type="checkbox" name="kitchen" value="true">kitchen<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["elevator"]))echo "checked";
							?>
							type="checkbox" name="elevator" value="true">elevator<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["no_smoking"]))echo "checked";
							?>
							type="checkbox" name="no_smoking" value="true">no smoking<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["television"]))echo "checked";
							?>
							type="checkbox" name="television" value="true">television<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["breakfast"]))echo "checked";
							?>
							type="checkbox" name="breakfast" value="true">breakfast<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["toiletries_provided"]))echo "checked";
							?>
							type="checkbox" name="toiletries_provided" value="true">toiletries provided<br></td>
							<td><input class="form-check-input active"
							<?php
								if(!empty($_POST["search"]) && !empty($_POST["shuttle_service"]))echo "checked";
							?>
							type="checkbox" name="shuttle_service" value="true">shuttle service<br></td>
						</tr>
					</tbody>
				</div>
			</table>
			<table class="table" style="height: 40px;">
				<thead class="thead-light">
					<tr>
						<form>
							<th scope="col">
								<input type="text" class="form-control" name="search_id" placeholder="ID"
								<?php
									if(!empty($_POST["search"]) && !empty($_POST["search_id"]))echo "value=\"" . $_POST["search_id"] . "\"";
								?>
								><br>
								ID
							</th>
							<th scope="col">
								<input type="text" class="form-control" name="search_name" placeholder="Name"
								<?php
									if(!empty($_POST["search"]) && !empty($_POST["search_name"]))echo "value=\"" . $_POST["search_name"] . "\"";
								?>
								><br>
								Name
							</th>
							<th scope="col">
								<div class="input-group">
									<input type="number" class="form-control" name="search_price_lb" placeholder="Lower"
									<?php
										if(!empty($_POST["search"]) && !empty($_POST["search_price_lb"]))echo "value=\"" . $_POST["search_price_lb"] . "\"";
									?>
									>
									<span class="input-group-addon">-</span>
									<input type="number" class="form-control" name="search_price_ub" placeholder="Upper"
									<?php
										if(!empty($_POST["search"]) && !empty($_POST["search_price_ub"]))echo "value=\"" . $_POST["search_price_ub"] . "\"";
									?>
									>
								</div>
								<br>
								Price
							</th>
							<th scope="col">
								<input type="text" class="form-control" name="search_location" placeholder="Location"
								<?php
									if(!empty($_POST["search"]) && !empty($_POST["search_location"]))echo "value=\"" . $_POST["search_location"] . "\"";
								?>
								><br>
								Location
							</th>
							<th scope="col">
								<input type="text" class="form-control" name="search_time" placeholder="Time"
								<?php
									if(!empty($_POST["search"]) && !empty($_POST["search_time"]))echo "value=\"" . $_POST["search_time"] . "\"";
								?>
								><br>
								Time
							</th>
							<th scope="col">
								<input type="text" class="form-control" name="search_owner" placeholder="Owner"
								<?php
									if(!empty($_POST["search"]) && !empty($_POST["search_owner"]))echo "value=\"" . $_POST["search_owner"] . "\"";
								?>
								><br>
								Owner
							</th>
							<th scope="col">
									<select class="form-control" style="width:7rem" name="sort">
									<option selected value="default">Sort by</option>
									<option value="pricea">Price asc</option>
									<option value="priced">Price desc</option>
									<option value="datea">Date asc</option>
									<option value="dated">Date desc</option>
									</select><br>
								Info
							</th>
							<th scope="col">
								<div class="btn-group">
									<button type="submit" name="search" value="1" class="btn btn-secondary">Search</button>
									<button type="submit" name="search" class="btn btn-secondary">Reset</button>
								</div><br><br>
								Operation
							</th>
						</form>
					</tr>
				</thead>
				<tbody>
				<?php
					if(empty($_POST["sort"]))$_POST["sort"] = "default";
					if($_SERVER["REQUEST_METHOD"] == "POST")
					{
						if(!empty($_POST["favorite"]) && $_SESSION["Authenticated"])
						{
							$ret = $pdo->prepare("insert into favorite (user_id, favorite_id) values (?, ?)");
							$ret->execute(array(intval($_SESSION["uid"]), intval($_POST["favorite"])));
						}
						if(!empty($_POST["delete"] && $_SESSION["Authenticated"] && $_SESSION["root"] == 1))
						{
							$ret = $pdo->prepare("delete from house where id = ?");
							$ret->execute(array(intval($_POST["delete"])));
							echo $_POST["delete"];
						}
					}
					$ret2 = $pdo->prepare("select * from favorite where user_id = " . $_SESSION["uid"]);
					$ret2->execute();
					$arr = array();
					while($re2 = $ret2->fetchObject())$arr[] = $re2->favorite_id;
					$sql = "select * from house ";
					if($_POST["sort"] == "default")$sql = $sql . "order by id asc";
					if($_POST["sort"] == "datea")$sql = $sql . "order by time asc";
					if($_POST["sort"] == "dated")$sql = $sql . "order by time desc";
					if($_POST["sort"] == "pricea")$sql = $sql . "order by price asc";
					if($_POST["sort"] == "priced")$sql = $sql . "order by price desc";
					$ret = $pdo->prepare($sql);
					$ret->execute();
					while($re = $ret->fetchObject())
					{
						$ret2 = $pdo->prepare("select * from account where id = " . $re->owner_id);
						$ret2->execute();
						while($re2 = $ret2->fetchObject())$owner = $re2->name;
						if(!empty($_POST["search"]))
						{
							if(!empty($_POST["search_id"]) && $re->id != $_POST["search_id"])continue;
							if(!empty($_POST["search_name"]) && $re->name != $_POST["search_name"])continue;
							if(!empty($_POST["search_price_ub"]) && $re->price > intval($_POST["search_price_ub"]))continue;
							if(!empty($_POST["search_price_lb"]) && $re->price < intval($_POST["search_price_lb"]))continue;
							if(!empty($_POST["search_location"]) && $re->location != $_POST["search_location"])continue;
							if(!empty($_POST["search_time"]) && $re->time != $_POST["search_time"])continue;
							if(!empty($_POST["search_owner"]) && $owner != $_POST["search_owner"])continue;
						}
						$flags = array("laundry facilities" => !empty($_POST["laundry_facilities"]), "wifi" => !empty($_POST["wifi"]), "lockers" => !empty($_POST["lockers"]), "kitchen" => !empty($_POST["kitchen"]), "elevator" => !empty($_POST["elevator"]), "no smoking" => !empty($_POST["no_smoking"]), "television" => !empty($_POST["television"]), "breakfast" => !empty($_POST["breakfast"]), "toiletries provided" => !empty($_POST["toiletries_provided"]), "shuttle service" => !empty($_POST["shuttle_service"]));
					
						$ret3 = $pdo->prepare("select * from information where house_id = " . $re->id);
						$ret3->execute();
						while($re3 = $ret3->fetchObject())$flags[$re3->information] = false;

						$flag = true;
						foreach ($flags as $i => $j)
						{
							if($j == true)
							{
								$flag = false;
								break;
							}
						}
						if($flag != true)break;
						$ret3 = $pdo->prepare("select * from information where house_id = " . $re->id);
						$ret3->execute();
						
						echo "<tr>";
						echo "<td>" . $re->id . "</td>\n";
						echo "<td>" . $re->name . "</td>\n";
						echo "<td>" . $re->price . "</td>\n";
						echo "<td>" . $re->location . "</td>\n";
						echo "<td>" . $re->time . "</td>\n";
						echo "<td>" . $owner . "</td>\n";
						$flag = true;
						foreach ($arr as $i => $j)
						{
							if($j == $re->id)
							{
								$flag = false;
								break;
							}
						}
						
						$ret3 = $pdo->prepare("select * from information where house_id = " . $re->id);
						$ret3->execute();
						echo "<td>";
						while($re3 = $ret3->fetchObject())
						{
							$flags[$re3->information] = 1;
							echo  "<span class=\"badge badge-pill badge-secondary\">" . $re3->information . "</span><br>";
						}
						echo "</td>";
						
						echo "<td><div class=\"btn-group\">";
						if($flag == true)echo "<button type=\"submit\" name=\"favorite\" value=\"" . $re->id . "\" class=\"btn btn-secondary\">favorite</button>";
						if($_SESSION["root"] == 1)echo "<button type=\"submit\" name=\"delete\" value=\"" . $re->id . "\" class=\"btn btn-secondary\">Delete</button>";
						$flags = array();
						echo "</div></td>";
						echo "</tr>";
					}
				?>
				</tbody>
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

