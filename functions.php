<?php
//functions.php
//see fail peab olema seotud k]igega, kus tahame sessiooni kasutada.
// nyyd saab kasutada $_SESSION muutujat 

require ("../../config.php");

session_start();
$database = "if16_thetloff";

function signup($email, $password) {


	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

	$stmt = $mysqli->prepare("
		INSERT INTO user_sample (email, password) VALUE (?, ?)");
	//Asendan küsimärgid
	// iga märgi kohta tuleb lisada üks täht - mis muutuja on
	// s - string
	// i - int
	// d - double
	// bind_param - määra muutuja  :: ss tähendab, et mõlemad muutujad on stringid. kui oleks si ,siis esimene muutuja oleks STR ja teine INT.
	$stmt ->bind_param("ss", $email, $password);

	if ($stmt->execute() ) {
		echo "õnnestus";
	} else {
		echo "ERROR ".$stmt->error;
	}
	}

function login($email, $password) {

	$notice = "";

	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

	$stmt = $mysqli->prepare("
		SELECT id, email, password, created
		FROM user_sample
		WHERE email = ?");

		echo $mysqli->error;

		$stmt->bind_param("s", $email);

		$stmt->bind_result($id, $emamilFormBd, $passwordFormDb, $created);

		$stmt->execute();

		if ($stmt->fetch()) {
			$hash = hash ("sha512", $password);
			if ($hash == $passwordFormDb) {
				echo "kasutaja $id logis sisse";

				$_SESSION["userid"] =$id;
				$_SESSION["userEmail"] =$emamilFormBd;

				header("Location: data.php");
				exit();

			} else {
				$notice = "parool on vale";
			} 
		} else {

			$notice = "sellise emailiga  ".$email."kasutajat ei ole olemas";
		}
		return $notice;
	}



function saveEvent($age, $color) {


	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

	$stmt = $mysqli->prepare("
		INSERT INTO whistle (age, color) VALUES (?, ?)");
	//Asendan küsimärgid
	// iga märgi kohta tuleb lisada üks täht - mis muutuja on
	// s - string
	// i - int
	// d - double
	// bind_param - määra muutuja  :: ss tähendab, et mõlemad muutujad on stringid. kui oleks si ,siis esimene muutuja oleks STR ja teine INT.
	$stmt ->bind_param("is", $age, $color);

	if ($stmt->execute() ) {
		echo "õnnestus";
	} else {
		echo "ERROR ".$stmt->error;
	}
	}

function getAllPeople (){

	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("
		SELECT id, age, color
		FROM whistle
		");

	$stmt->bind_result($id, $age, $color);
	$stmt->execute();

	$results = array();
// while töötab niimitu korda kui palju on mysql päringutes ridasid
	while ($stmt->fetch())	{
		//echo $color."<br>";
		$human = new StdClass();
		$human->id = $id;
		$human->age = $age;
		$human->lightColor = $color;

		array_push($results, $human);

	}
	return $results;

}

function cleanInput ($input) 
	{
// kustutab alguses ja lõpus olevad tühikud ära
		$input = trim($input);
// kustutab \ tagurpidi kaldkriipsud
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
// SAMA return htmlspecialchars(stripslashes($input(trim)));


	}

/*

function sum($x, $y) {

	return "$x $y";
}

echo sum("tere", "tulemast");
echo "<br>";

function hello ($firstName, $lastName){

	return "Tere tulemast ".$firstName." ".lastName."!";
}*/
?>