<html>
<body>
<?php
						$host = "dbhome.cs.nctu.edu.tw";
						$username = "cjwang0416_cs";
						$passwd = "A4B5C6d7";
						$db = "cjwang0416_cs_HW1";
		//				$dsn = "mysql:host=$host;dbname=$db";
						$dsn = "mysql:host=localhost;dbname=newdb";
			//			$pdo = new PDO($dsn, $username, $passwd);
						$pdo = new PDO($dsn, "reader");
						$sql = "select * from `test`";
						$ret = $pdo->query($sql);
						while($sth = $ret->fetchObject())
						{
							echo $sth->a;
							echo " ";
							echo $sth->b;
							echo "<br>";
							//echo 'in';
						}
						//echo 'out';
?>
</body>
</html>
