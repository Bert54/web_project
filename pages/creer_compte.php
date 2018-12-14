<?php

/**
 * Cette page chargée par AJAX permet de créer un nouveau comtpe utilisateur et connecte automatiquement
 * l'utilisateur qui a saisit les informations.
 */
	
	$nickname = $_REQUEST["nickname"];
	$password = sha1($_REQUEST["password"]);
	$firstname = $_REQUEST["firstname"];
	$lastname = $_REQUEST["lastname"];
	$gender = $_REQUEST["gender"];
	$mail = $_REQUEST["mail"];
	$date = $_REQUEST["date"];
	$addrnumber = $_REQUEST["addrnumber"];
	$addrstreet = $_REQUEST["addrstreet"];
	$city = $_REQUEST["city"];
	$phone = $_REQUEST["phone"];
	
	include("../bdd_connexion.php");
	
	if (!($stmt = $db_connection->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);"))) {
		echo "Echec lors du liage des paramètres " . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->bind_param("sssssssssss", $nickname, $password, $firstname, $lastname, $gender, $mail, $date, $addrstreet, $addrnumber, $city, $phone);
	$stmt->execute();
	$stmt->store_result();
	$stmt->close();
	if (!($stmt = $db_connection->prepare("INSERT INTO user_recipes VALUES (?, ?);"))) {
		echo "Echec lors du liage des paramètres " . $stmt->errno . ") " . $stmt->error;
	}
	$temp = "";
	$stmt->bind_param("ss", $nickname, $temp);
	$stmt->execute();
	$stmt->store_result();
	$stmt->close();
	session_start();
	$_SESSION['boissons_user_connected'] = true;
	$_SESSION['boissons_user_nickname'] = $nickname;
	$_SESSION['boissons_user_just_connected'] = true;
	mysqli_close($db_connection);
?>