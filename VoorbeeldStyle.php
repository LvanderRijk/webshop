<!DOCTYPE html>
<html>
<?php
	$host="localhost";
	$dbname="workshop";
	$username="root";
	$password="";
	
	$con = new PDO("mysql:host=$host;dbname=$dbname","$username","$password") or die("Verbinding mislukt!");
	session_start();
	?>
<head>
	<link rel="stylesheet" href="Style.css">;
	<title>Aanmeldformulier workshop</title>
</head>
<body>
	<h1> Aanmelding workshop Webdesign!</h1>
	<p>
	Leuk dat je jezelf wilt aanmelden voor de workshop Webdesign!<br/>
	Vul hier onder je gegevens in en je voorkeur voor een datum en wij nemen zo snel mogelijk contact met je op.
	
	</p>
	<form method="POST">
	Aanhef: <select name="Aanhef">
				<option value="De heer">De heer</option>
				<option value="Mevrouw">Mevrouw</option>
				<option value="Niet aangegeven" selected="selected">Niet aangeven</option> </select><br/>
	Voornaam: <input type="text" name="naamVoor" placeholder="Jan"/>
	Achternaam: <input type="text" name="naamAchter" placeholder="Janssen"/><br/>
	Geslacht: <input type="radio" name="Gender" value="Man"> Man <input type="radio" name="Gender" value="Vrouw"> vrouw <input type="radio" name="Gender" checked="checked" value="Niet aangegeven"> Niet delen <br/>
	Geboortedatum: <input type="text" name="birthday" placeholder="dd-mm-jjjj"><br/>
	Adres: <input type="text" name="address" placeholder="Hoofdstraat 1B"><br/>
	Postcode en woonplaats: <input type="text" name="postalcode" placeholder="1234 AB Amsterdam"><br/>
	Telefoonnummer: <input type="text" name="phonenumber" placeholder="06-12345678"><br/>
	E-mailadres: <input type="text" name="email" placeholder="voorbeeld@voorbeeld.nl"><br/>
	Gewenste datum: <select name="Date">
						<option value="13 februari 2020">dinsdag 13 februari 2020 van 09.00u - 13.30u.</option>
						<option value="14 februari 2020">woensdag 14 februari 2020 van 13.00u - 17.30u. </option></select><br/>
	<input type="submit" name="buttonSubmit" value="verstuur">					
	</form>
	<br/>
	<br/>
	<br/>
<?php
	echo "<div class='Echo'>";
	if(isset($_POST['buttonSubmit']))
	{
	$webshop=array("Aanhef"=>$_POST["Aanhef"],
					"Naam"=>$_POST["naamVoor"]." ".$_POST["naamAchter"],
					"Geslacht"=>$_POST["Gender"],
					"Geboortedatum"=>$_POST["birthday"],
					"Adres"=>$_POST["address"],
					"Postcode/Woonplaats"=>$_POST["postalcode"],
					"Telefoonnummer"=>$_POST["phonenumber"],
					"E-mailadres"=>$_POST["email"],
					"Gewenste datum"=>$_POST["Date"]);
	//var_dump($lijst);
	/*foreach($webshop as $item => $value)
{
	echo $item. ": ".$value. '<br/>';
	
}*/
	}
	else{
		echo "Geen gegevens ingevuld.";
	}
	
	echo "</div>";
	if (isset($_POST['buttonSubmit'])){
		
		$aanhef= $_POST['Aanhef'];
		$Geslacht= $_POST['Gender'];
		$Naam= $_POST['naamVoor']." ". $_POST['naamAchter'];
		$Adres= $_POST['address'];
		$Postcode= $_POST['postalcode'];
		$Telefoonnummer= $_POST['phonenumber'];
		$Email= $_POST['email'];
		$Datum= $_POST['Date'];
		$query = "SELECT * FROM klantgegevens WHERE Datum='$Datum'";
		$stm=$con->prepare($query);
		if($stm->execute()){
			$aanmeldingen=$stm->fetchAll (PDO::FETCH_OBJ);
			if ($stm->rowcount() > 20){
				echo "U kunt uzelf niet meer aanmelden voor deze dag.";
			}
		}
		else {
		$query="INSERT INTO klantgegevens (aanhef, Geslacht, Naam, Adres, Postcode, Telefoonnummer, Email, Datum) VALUES"
		. "('$aanhef','$Geslacht','$Naam','$Adres','$Postcode','$Telefoonnummer','$Email','$Datum')";
		//var_dump($query);
		$stm = $con->prepare($query);
		
		echo "<div class='statement'>";
		if($stm->execute()){
			echo "gegevens succesvol ingezonden";
		}
		else{
			echo "Gegevens zijn niet ingezonden! Probeer opnieuw!";
		}
		echo "</div>";}
		
		echo "<h2>Overzicht aanmeldingen per dag</h2>";
		echo "<h3> Dinsdag 13 Februari</h3>";
		$query = "SELECT * FROM klantgegevens WHERE Datum='13 Februari 2020'";
		$stm=$con->prepare($query);
		if($stm->execute()){
			$aanmeldingen=$stm->fetchAll (PDO::FETCH_OBJ);
			if(count($aanmeldingen) > 20){
				echo "Er zijn te veel aanmeldingen op deze dag!";
			}
			else{
				echo "aantal vrije plekken: " . (20-$stm->rowcount()) . "<br/>";
				foreach($aanmeldingen as $aanmelding){
					echo $aanmelding->aanhef . " ". $aanmelding->Naam . " <br/>" . $aanmelding->Adres . " " . $aanmelding->Postcode . "<br/>". $aanmelding->Telefoonnummer . " <br/>" . $aanmelding->Email . "<br/>" . $aanmelding->Datum . "<br/> <br/>";
					
				}
			}
	}
	
	echo "<h3> Woensdag 14 Februari</h3>";
	$query = "SELECT * FROM klantgegevens WHERE Datum='14 Februari 2020'";
	$stm=$con->prepare($query);
	if($stm->execute()){
		$aanmeldingen=$stm->fetchAll (PDO::FETCH_OBJ);
		if(count($aanmeldingen) > 20){
			echo "Er zijn te veel aanmeldingen op deze dag!";
		}
		else{
			echo "Aantal vrije plekken: " . (20-$stm->rowcount()). "<br/><br/>";
			foreach($aanmeldingen as $aanmelding){
				echo $aanmelding->aanhef . " ". $aanmelding->Naam . " <br/>" . $aanmelding->Adres . " " . $aanmelding->Postcode . "<br/>". $aanmelding->Telefoonnummer . " <br/>" . $aanmelding->Email . "<br/>" . $aanmelding->Datum . "<br/> <br/>";
				
			}
		}
	}
	}	
	?>
</body>
</html>