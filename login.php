<?php
	// kutsutakse fail config.php
	
	require("./functions.php");
	// kui on sisse loginud, siis suunan data.php lehele
		if (isset($_SESSION["userid"])) {
		header("Location: data.php");
	}

	
	// var_dump ($_GET);
	// echo "<br>";
	// var_dump ($_POST);

//MUUTUJAD
$signupEmailError = "*";
$signupEmail = "*";

//Kasutajanime sisestamise kontroll
	$signupEmailError = "*";

if (isset ($_POST["signupEmail"])) {

	if (empty ($_POST["signupEmail"])) {
		// on tühi
			$signupEmailError = "* Väli on kohustuslik!";
			
		} else {
			// email on olemas ja õige
			$signupEmail = $_POST["signupEmail"];
			
		}

	}
$gender = "";
$genderError = "";

if (isset ($_POST["gender"])) {

	if (empty ($_POST["gender"])) {
		// on tühi
			$genderError = "Väli on kohustuslik!";
			
		} else {
			// sugu on määratud
			$gender = $_POST["gender"];
			
		}

	}





//Kasutaja parooli sisestamise kontroll
$signupPasswordError = "*";

if (isset ($_POST["signupPassword"])) {

	if (empty ($_POST["signupPassword"])) {

		$signupPasswordError = "vali on kohustuslik";
		
	} else {
		if (strlen($_POST["signupPassword"]) < 8 ) {

			$signupPasswordError = " parool peab olema vähemalt 8 tähemärki pikk";
		}
	}

	}


//Pangakaardi andmete sisestamise kontroll
$creditCardError = "*";

if (isset ($_POST["creditCard"])) {

	// kas on tyhi?
	// on olemas

	if (empty ($_POST["creditCard"])) {

		$creditCardError = "vali on kohustuslik";
	} else {

		if (strlen($_POST["creditCard"]) != 16 ) {

			$creditCardError = " Pangakaardi number peab olema 16 tähemärki pikk";
		}


	//on tyhi

	echo "<br><br>";
	}

}


//Pangakaardi parooli sisestamise kontroll
$creditCardPasswordError = "*";

if (isset ($_POST["creditCardPassword"])) {

	// kas on tyhi?
	// on olemas

	if (empty ($_POST["creditCardPassword"])) {

	//on tyhi

	$creditCardPasswordError = " kaardi parool on puudu";
	}

}
/*
Kuvab lihtsalt sisestatud Signupi andmed
echo $signupEmailError;
echo $signupPasswordError;
echo $signupEmail;
echo $_POST["signupPassword"];
*/

if ($signupEmailError == "*" &&
	$signupPasswordError == "*" &&
	isset($_POST["signupEmail"]) &&
	isset($_POST["signupPassword"])
)	{
	
// vigu ei olnud, kõik on olemas, salvestan
	echo "Salvestan.. <br>";
	echo "email ".$signupEmail."<br>";
	echo "parool".$_POST["signupPassword"]."<br>";

	$password = hash("sha512", $_POST["signupPassword"]);
	echo $password."<br>";

	signup($signupEmail, $password);
//Loon ühenduse user_sample mysql tabeliga
	// siit viide functions.php faili



}

$notice ="";
if (isset($_POST["loginEmail"]) &&
 	isset($_POST["loginPassword"]) &&
 	!empty($_POST["loginEmail"]) &&
 	!empty($_POST["loginPassword"])
 	) {

 	$notice = login ($_POST["loginEmail"], $_POST["loginPassword"]);	
 	
 	}

	

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<p style="color:red"><?=$notice;?></p>
			<form method="POST">

				<input type="email" placeholder="sisesta e-post" name="loginEmail">
				<br><br>
				<input type="password" placeholder="sisesta parool" name="loginPassword">
				<br><br>
				<input type="submit" value="logi sisse">
			</form>

		<h1>Loo kasutaja</h1>
			<form method="POST">

				<input type="email" placeholder="loo kasutaja" name="signupEmail" value="<?=$signupEmail;?>"><?php echo $signupEmailError; ?>
				<br><br>
				<input type="password" placeholder="sisesta parool" name="signupPassword"><?php echo $signupPasswordError; ?>
				<br><br>
				<input type="submit" value="loo kasutaja">
		
		
		<h1>Sisesta pangakaardi andmed</h1>
			

				<input type="text" placeholder="sisesta pangakaardi andmed" name="creditCard" maxlength=16><?php echo $creditCardError; ?>
				<br><br>
				<input type="password" placeholder="sisesta pangakaardi parool" name="creditCardPassword" maxlength=4><?php echo $creditCardPasswordError; ?>
				<br><br>
			
		
		
		<h1>Määra enda sugu</h1>
			

				 <?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> female<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female" > female<br>
			<?php } ?>
			
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> male<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male" > male<br>
			<?php } ?>
			
			
			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> other<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other" > other<br>
			<?php } ?>

				<input type="submit" value="edasta andmed">
		</form>

	</body>
</html>