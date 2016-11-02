<?php
//functions.php
//see fail peab olema seotud k]igega, kus tahame sessiooni kasutada.
// nyyd saab kasutada $_SESSION muutujat 

require ("../../config.php");

session_start();
$database = "if16_thetloff";

function signup($email, $password) {


	$mysqli = new mysqli(
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);

	$stmt = $mysqli->prepare("
		INSERT INTO user_sample (email, password) VALUES (?, ?)");
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

	$mysqli = new mysqli(
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);

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


	$mysqli = new mysqli(
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);

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

	$mysqli = new mysqli(
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
	$stmt = $mysqli->prepare("
		SELECT id, age, color
		FROM whistle
		WHERE deleted IS NULL 
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
		return $input;

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

function saveInterest ($interest) {
	echo $interest;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO interests (interest) VALUES (?)");

	echo $mysqli->error;
	
	$stmt->bind_param("s", $interest);
	
	if($stmt->execute()) {
		echo "salvestamine õnnestus";
	} else {
	 	echo "ERROR ".$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	
}

function saveUserInterestID ($interest) {
	echo $interest;
	$mysqli = new mysqli(
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);

	$stmt = $mysqli->prepare("
		SELECT id FROM user_interests 
		WHERE user_id=? AND interest_id=?
		");
	$stmt->bind_param("ii", $_SESSION["userid"], $interest);
	$stmt->execute();
//kas oli rida juba olemas
	if ($stmt->fetch()) {
// oli juba olemas	
		echo "juba olemas";
//pärast returni koodi enam ei vaadata
		return;

	}

	$stmt->close();

	$stmt = $mysqli->prepare("INSERT INTO user_interests (user_id, interest_id) VALUES (?,?)");

echo $mysqli->error;
	
	$stmt->bind_param("ii", $_SESSION["userid"], $interest);
	
	if($stmt->execute()) {
		echo "salvestamine õnnestus";
	} else {
	 	echo "ERROR ".$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	
}

function getAllInterests() {
	
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("
		SELECT id, interest
		FROM interests
	");
	echo $mysqli->error;
	
	$stmt->bind_result($id, $interest);
	$stmt->execute();
	
	
	//tekitan massiivi
	$result = array();
	
	// tee seda seni, kuni on rida andmeid
	// mis vastab select lausele
	while ($stmt->fetch()) {
		
		//tekitan objekti
		$i = new StdClass();
		
		$i->id = $id;
		$i->interest = $interest;
	
		array_push($result, $i);
	}
	
	$stmt->close();
	$mysqli->close();
	
	return $result;
}
	
function getUserInterests() {
	
	$mysqli = new mysqli(
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("
		SELECT interest 
		FROM interests
		JOIN user_interests 
		ON user_interests.interest_id=interests.id
		WHERE user_interests.user_id=?
	");

echo $mysqli->error;

	$stmt->bind_param("i", $_SESSION["userid"]);

	$stmt->bind_result($interest);
	$stmt->execute();
	
	
	//tekitan massiivi
	$result = array();
	
	// tee seda seni, kuni on rida andmeid
	// mis vastab select lausele
	while ($stmt->fetch()) {
		
		//tekitan objekti
		$i = new StdClass();
		
		$i->interest = $interest;
	
		array_push($result, $i);
	}
	
	$stmt->close();
	$mysqli->close();
	
	return $result;
}	
	
	
	
	/*function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	echo sum(12312312,12312355553);
	echo "<br>";
	
	
	function hello($firstname, $lastname) {
		return 
		"Tere tulemast "
		.$firstname
		." "
		.$lastname
		."!";
	}
	
	echo hello("romil", "robtsenkov");
	*/

?>