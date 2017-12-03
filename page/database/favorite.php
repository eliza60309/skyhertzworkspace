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
			</ul>
		</div>
	</nav>


	<div class="container" align="center">
		<h3>Favorite</h3><!--</div>-->
		<h4>
			<?php
				if($_SESSION["Authenticated"] != true)
				{
					header("Location: /database/logout.php");
					exit();
				}
				$dsn = "mysql:host=localhost;dbname=db";
				$pdo = new PDO($dsn, "webuser");
			?>
		</h4>
		<form action="/database/favorite.php" method="post">
			<table class="table" style="height: 40px;">
				<thead class="thead-light">
					<tr>
						<form>
							<th scope="col">ID</th>
							<th scope="col">Name</th>
							<th scope="col">Price</th>
							<th scope="col">Location</th>
							<th scope="col">Time</th>
							<th scope="col">Owner</th>
							<th scope="col">Operation</th>
						</form>
					</tr>
				</thead>
				<tbody>
				<?php
					if($_SERVER["REQUEST_METHOD"] == "POST")
					{//////
						if(!empty($_POST["delete"] && $_SESSION["Authenticated"]))
						{
							$ret = $pdo->prepare("delete from favorite where favorite_id = ? and user_id = ?");
							$ret->execute(array(intval($_POST["delete"]), intval($_SESSION["uid"])));
						}
					}
					$ret = $pdo->prepare("select * from house as a join favorite as b where a.id = b.favorite_id and user_id = " . $_SESSION["uid"]);
					$ret->execute();
					$arr = array();
					$notfound = true;
					while($re = $ret->fetchObject())
					{
						$ret2 = $pdo->prepare("select * from account where id = " . $re->owner_id);
						$ret2->execute();
						while($re2 = $ret2->fetchObject())$owner = $re2->name;
						$flags = array("laundry facilities" => !empty($_POST["laundry_facilities"]), "wifi" => !empty($_POST["wifi"]), "lockers" => !empty($_POST["lockers"]), "kitchen" => !empty($_POST["kitchen"]), "elevator" => !empty($_POST["elevator"]), "no smoking" => !empty($_POST["no_smoking"]), "television" => !empty($_POST["television"]), "breakfast" => !empty($_POST["breakfast"]), "toiletries provided" => !empty($_POST["toiletries_provided"]), "shuttle service" => !empty($_POST["shuttle_service"]));
					
						$ret3 = $pdo->prepare("select * from information where house_id = " . $re->id);
						$ret3->execute();
						
						echo "<tr>";
						echo "<td>" . $re->favorite_id . "</td>\n";
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
						
						$ret3 = $pdo->prepare("select * from information where house_id = " . $re->favorite_id);
						$ret3->execute();
						echo "<td>";
						while($re3 = $ret3->fetchObject())
						{
							$flags[$re3->information] = 1;
							echo  "<span class=\"badge badge-pill badge-secondary\">" . $re3->information . "</span><br>";
						}
						echo "</td>";
						
						echo "<td><div class=\"btn-group\">";
						echo "<button type=\"submit\" name=\"delete\" value=\"" . $re->favorite_id . "\" class=\"btn btn-secondary\">Delete favorite</button>";
						$flags = array();
						echo "</div></td>";
						echo "</tr>";
						$notfound = false;
					}
				?>
				</tbody>
			</table>
			<?php
					if($notfound == true)echo "<img src=\"nofavorite.jpg\" width=\"650\" height=\"343\">"
			?>
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

