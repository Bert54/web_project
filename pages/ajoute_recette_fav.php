<?php

/**
 *  Cette page chargée par AJAX permet d'ajouter une recette à la liste des recettes favorites de l'utilisateur
 *
 */
	session_start();
	include("../bdd_connexion.php");
    $elem = $_REQUEST["elem"];
	if ($_SESSION['boissons_user_connected']) {
		$empty = false;
		$stmt = $db_connection->prepare("SELECT fav_recipes FROM user_recipes WHERE LOWER(nickname)=LOWER(?);");
		$stmt->bind_param("s", $_SESSION['boissons_user_nickname']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($db_user_recipes);
		$stmt->fetch();
		$db_user_recipes_cpy = $db_user_recipes;
		if (strcmp($db_user_recipes, "") == 0) {
			$empty = true;
			$user_recipes = array();
		}
		else {
			$user_recipes = explode("|", $db_user_recipes);
		}
		$stmt->close();
		if (!in_array($elem, $user_recipes)) {
			if ($empty) {
				$db_user_recipes_cpy = $elem;
			}
			else {
				$db_user_recipes_cpy = $db_user_recipes_cpy."|".$elem;
			}
			$stmt = $db_connection->prepare("UPDATE user_recipes SET fav_recipes=? WHERE LOWER(nickname)=LOWER(?);");
			$stmt->bind_param("ss", $db_user_recipes_cpy, $_SESSION['boissons_user_nickname']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->close();
		}
	}
	else {
		//$user_recipes = json_decode($_COOKIE['user_recipes'], true);
		$user_recipes = json_decode($_SESSION['user_recipes']);
		if (!in_array($elem, $user_recipes)) {
			array_push($user_recipes, $elem);
			//setcookie('user_recipes', json_encode($user_recipes), time() + 36000);
			$_SESSION['user_recipes'] = json_encode($user_recipes);
		}
	}
	mysqli_close($db_connection);
?>