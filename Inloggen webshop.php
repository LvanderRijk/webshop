<!DOCTYPE html>
<html>
<?php
	$host="localhost";
	$dbname="workshop";
	$username="root";
	$password="";
	
	$con = new PDO("mysql:host=$host;dbname=$dbname","$username","$password") or die("Verbinding mislukt!");
	
	?>
<head>
	<link rel="stylesheet" href="Style.css">;
	<title>Aanmeldscherm workshop</title>
</head>
<body>
<form method="POST">
Welkom op de aanmeldsite voor de workshop.<br/> 
Vul hieronder uw gebruikersnaam en wachtwoord in om uwzelf aan te kunnen melden<br/> <br/><br/>
Gebruikersnaam: <input type="text" name="Username"/><br/>
Wachtwoord : <input type="password" name="password"/><br/>
<input type="submit" name="Login" value="Inloggen"/><br/>
<?php

if (isset($_POST['Login'])){
	$Id = 0;
	$Username = $_POST['Username'];
	$Password = $_POST['password'];
	
	$query = "Select * from inloggen WHERE Username = '$Username' AND Password = '$Password'";
	$stm= $con->prepare($query);
	if($stm->execute()){
		$result=$stm->fetchAll (PDO::FETCH_OBJ);
		if(count($result) > 0)
		{
		session_start();
		echo "<br/>Succesvol ingelogd!";
		sleep(3);
		header("Location: VoorbeeldStyle.php");
		}else{
		echo "<br/>Inloggen mislukt" ;
	}
	}
	

}

?>
</body>
</html>