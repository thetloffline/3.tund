<?php 
	//yhendan sessiooniga
	
	require ("functions.php");
	

	// kui ei ole sisse loginud, suunan login lehele
	if (!isset($_SESSION["userid"])) {
		header("Location: login.php");
		exit();
	}

// defineerin muutujad

$age = "";
$color = "";

	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}

	if (isset($_POST['age']) &&
		isset($_POST['color']) ) {

			saveEvent(cleanInput($_POST['age'], $_POST['color']));		// muutujad peavad olema samad mis form osas NAME . järjekord ka sama !

		header("Location: login.php");
		exit();
	}

$people = getAllPeople();

echo "<pre>";
var_dump($people[3]);
echo "</pre>";


 ?>
 <h1>Data</h1>
 <p>
 		Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
 		<a href="?logout=1">logi valja</a>
 </p>


 <h1>Vaatlus</h1>
 <form method="POST">

				<input type="age" placeholder="sisesta vanus" name="age">
				<br><br>
				<input type="color" placeholder="sisesta värv" name="color">
				<br><br>
				<input type="submit" value="salvesta">


	</form>

	<h2>Arhiiv</h2>
	
	<?php 

		$html = "<table>";
			$html .= "<tr>";
				$html .= "<th>ID</th>";
				$html .= "<th>Vanus</th>";
				$html .= "<th>Värv</th>";
			$html .= "</tr>";

			foreach ($people as $p) {
				$html .= "<tr>";
					$html .= "<td>".$p->id."</th>";
					$html .= "<td>".$p->age."</th>";
					$html .= "<td>".$p->lightColor."</th>";
				$html .= "</tr>";


			}
		$html .= "</table>";		

		echo $html;

	 ?>


	 <h2>Midagi huvitavat</h2>
	 <?php  
	 foreach ($people as $p)	{
	 	$style = "
	 	background-color: ".$p->lightColor.";
	 	width: 40px;
	 	height: 40px;
	 	border-radius: 20px;
	 	text-align: center;
	 	line-height: 39px;
	 	float: left;
	 	margin: 20px;
	 	";

	 	echo "<p style ='	".$style."	'>".$p->age."</p>";

	 }






	 ?>