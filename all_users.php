<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Les excuses du lundi matin</title>
	  
		<link href="css/monStyle.css" rel="stylesheet">
		
		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	</head>
	<body>
		<?php 
			$host='localhost';
			$db='my_activities';
			$user='root';
			$pass='root';
			$charset='utf8mb4';
			$dsn="mysql:host=$host;dbname=$db;charset=$charset";
			$options=[
				PDO::ATTR_ERRMODE				=>PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE	=>PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES		=>false,];
			try{
				$pdo=new PDO($dsn,$user,$pass,$options);
			}catch(PDOException$e){
				throw new PDOException($e->getMessage(),(int)$e->getCode());
			}
			//$stmt = $pdo->query('SELECT * FROM users WHERE status_id="2" AND username LIKE \'e%\' ORDER BY username');
			$stmt = $pdo->query('SELECT users.id,username,email,status.name FROM users JOIN status ON users.status_id = status.id ORDER BY username');
			echo "<table border-bottom=\"1px\">";
			echo "<tr>";
				echo "<td>Id</td>";
				echo "<td>Username</td>";
				echo "<td>Email</td>";
				echo "<td>Status</td>";
				echo "</tr>";
			while($row = $stmt->fetch()){
				echo "<tr>";
				echo "<td>".$row['id']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['email']."</td>";
				echo "<td>".$row['name']."</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
	</body>
</html>