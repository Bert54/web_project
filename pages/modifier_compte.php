<?php

/**
 * Cette page appelée par AJAX modifie les informations d'un compte utilisateur depuis le formulaire de modification
 * de compte. SI un nouveau mote de passe a été saisie, alors on met également à jour celui-ci, sinon on laisse
 * l'ancien.
 */

	session_start();
	
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
	
	if ($password == "") {
		$stmt = $db_connection->prepare("UPDATE users SET first_name=?, last_name=?, gender=?, mail_address=?, birth_date=?, address_street=?, address_number=?, address_town=?, phone_number=? WHERE LOWER(nickname) = LOWER(?);");
		$stmt->bind_param("ssssssssss", $firstname, $lastname, $gender, $mail, $date, $addrstreet, $addrnumber, $city, $phone, $_SESSION['boissons_user_nickname']);
	}
	else {
		$stmt = $db_connection->prepare("UPDATE users SET password=?, first_name=?, last_name=?, gender=?, mail_address=?, birth_date=?, address_street=?, address_number=?, address_town=?, phone_number=? WHERE LOWER(nickname) = LOWER(?);");
		$stmt->bind_param("sssssssssss", $password, $firstname, $lastname, $gender, $mail, $date, $addrstreet, $addrnumber, $city, $phone, $_SESSION['boissons_user_nickname']);
	}
	$stmt->execute();
	$stmt->store_result();
	$stmt->close();
	mysqli_close($db_connection);
?>