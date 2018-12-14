<?php

/**
 *  Cette page chargée par AJAX permet de vérifier les informations saisies par l'utilisateur dans le formulaire de
 *  connexion. Si le pseudonyme n'existe pas, alors on affiche une erreur. ON affiche également une erreur si
 *  le mot de passe saisie est incorrect si le pseudo entré existe.
 */


	$nickname = $_REQUEST["nickname"];
	$password = sha1($_REQUEST["password"]);
	
	include("../bdd_connexion.php");
	
	$stmt = $db_connection->prepare("SELECT nickname FROM users WHERE LOWER(nickname)=LOWER(?);");
	$stmt->bind_param("s", $nickname);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($nickname_result);
	if ($stmt->num_rows == 0) {
		echo "<p style='color:red;'> - Le pseudonyme saisie n'existe pas.</p>";
	}
	else {
		$stmt->fetch();
		$stmt = $db_connection->prepare("SELECT nickname FROM users WHERE LOWER(nickname)=LOWER(?) AND password=?;");
		$stmt->bind_param("ss", $nickname, $password);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($nickname_result);
		if ($stmt->num_rows == 0) {
			echo "<p style='color:red;'> - Le mot de passe saisie est incorrect.</p>";
		}
		else {
			session_start();
			$_SESSION['boissons_user_connected'] = true;
			$_SESSION['boissons_user_nickname'] = $nickname_result;
			$_SESSION['boissons_user_just_connected'] = true;
		}
	}
	$stmt->close();
	mysqli_close($db_connection);
?>