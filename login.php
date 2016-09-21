<?php
	// var_dump ($_GET);
	// echo "<br>";
	// var_dump ($_POST);

	$signupEmailError = "Väli on kohustuslik";

	// KAS KEEGI VAJUTAS NUPPU JA E-POST ON YLDSE OLEMAS?

if (isset ($_POST["signupEmail"])) {

	// kas on tyhi?
	// on olemas

	if (empty ($_POST["signupEmail"])) {

	//on tyhi

	echo "e-post on tyhi";
	}

}
echo "<br><br>";
$signupPasswordlError = "Väli on kohustuslik";

	// KAS KEEGI VAJUTAS NUPPU JA E-POST ON YLDSE OLEMAS?

if (isset ($_POST["signupPassword"])) {

	// on olemas
	// kas on tyhi

	if (empty ($_POST["signupPassword"])) 

	else {

		if (strlen($_POST["signupPassword"]) < 8 ) {

			$signupPasswordlError = "parool peab olema v2hemalt 8 t2hem2rki pikk";
		}
	}

	echo "parool on puudu";
	}

}


	// KAS E-POST ON TYHI?
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
			<form method="POST">

				<input type="email" placeholder="sisesta e-post" name="loginEmail">
				<br><br>
				<input type="password" placeholder="sisesta parool" name="loginPassword">
				<br><br>
				<input type="submit" value="logi sisse">
			</form>

		<h1>Loo kasutaja</h1>
			<form method="POST">

				<input type="email" placeholder="loo kasutaja" name="signupEmail"><?php echo $signupEmailError; ?>
				<br><br>
				<input type="password" placeholder="sisesta parool" name="signupPassword"><?php echo $signupPasswordlError; ?>
				<br><br>
				<input type="submit" value="loo kasutaja">
		</form>
	</body>
</html>