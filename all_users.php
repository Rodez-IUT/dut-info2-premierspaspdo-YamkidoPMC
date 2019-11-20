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
			/*$stmt = $pdo->query("SELECT users.id,username,email,status.name FROM users JOIN status ON users.status_id = status.id ORDER BY username");*/
			
			echo "<form method=\"post\">";
			echo "<input type=\"text\" id=\"lettre\" name=\"lettreV\"></input>";
			echo "<select id=\"status\" name=\"statusV\">";
			echo "<option value=\"1\">Waiting for account validation</option>";
			echo "<option value=\"2\">Active Account</option>";
			echo "<option value=\"3\">Waiting for account deletion</option>";
			echo "</select>";
			echo "<input type=\"submit\" id=\"bouton\" name=\"Chercher\"></input>";
			echo "</form>";
			
			if (isset($_POST['statusV'])) {
				if(isset($_POST['lettreV']) && $_POST['lettreV'] != "") {
					$lettre = $_POST['lettreV'];
				} else {
					$lettre = "";
				}
				$statusVoulu = $_POST['statusV'];
				$stmt = $pdo->prepare("SELECT users.id,username,email,status.name 
								 FROM users 
								 JOIN status 
								 ON users.status_id = status.id 
								 WHERE status.id = :statusVoulu 
								 AND username 
								 LIKE :lettre
								 ORDER BY username");
				$stmt->bindValue(':statusVoulu', $statusVoulu, PDO::PARAM_INT);
				$stmt->bindValue(':lettre', $lettre.'%', PDO::PARAM_STR);
				$stmt->execute();
				
			} else {
				$stmt = $pdo->query("SELECT users.id,username,email,status.name 
								 FROM users 
								 JOIN status 
								 ON users.status_id = status.id 
								 ORDER BY username");
			}
			
			
			echo "<table border=\"1px\">";
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