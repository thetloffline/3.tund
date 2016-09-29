<?php
//functions.php
//see fail peab olema seotud k]igega, kus tahame sessiooni kasutada.
// nyyd saab kasutada $_SESSION muutujat 

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



			} else {
				$notice = "parool on vale";
			} 
		} else {

			$notice = "sellise emailiga  ".$email."kasutajat ei ole olemas";
		}
		return $notice;
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