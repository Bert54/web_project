<?php
/**
 *  Cette page chargée par AJAX permet de vérifier si le pseudo saisie dans le formulaire de création de compte
 *  existe déjà. Si c'est le cas, alors on génère une erreur.
 */

	$nickname = $_REQUEST["nickname"];
	$db_connection = new mysqli("localhost", "root", "", "projet_boisson_db");
	if ($db_connection->connect_error) {
		die("Connection failed: " . $db_connection->connect_error);
	}
	$stmt = $db_connection->prepare("SELECT nickname FROM users WHERE LOWER(nickname)=LOWER(?);");
	$stmt->bind_param("s", $nickname);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($nicknames_result);
	if ($stmt->num_rows != 0) {
		echo "<p style='color:red;'> - Le pseudonyme saisie existe déjà.</p>";
	}
	$stmt->close();
	mysqli_close($db_connection);
?>