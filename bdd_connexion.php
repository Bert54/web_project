<?php

/**
 * Inclure ce fichier permet de se connecter à une base de donnée. il suffit de modifier la première ligne
 * afin de changer la bdd à laquelle se connecter.
 */
	$db_connection = new mysqli("localhost", "root", "", "projet_boisson_db");
	if ($db_connection->connect_error) {
		die("Connection failed: " . $db_connection->connect_error);
	}
?>