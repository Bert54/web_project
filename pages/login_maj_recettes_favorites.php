<?php

/**
 * Cette page PHP chargée par AJAX met à jour la liste des recettes favorites de l'utilisateur lorsque celui-ci
 * vient de se connecter.
 */

	include("../bdd_connexion.php");
	session_start();
	$found = false;
	$stmt = $db_connection->prepare("SELECT fav_recipes FROM user_recipes WHERE LOWER(nickname)=LOWER(?);");
	$stmt->bind_param("s", $_SESSION['boissons_user_nickname']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($db_user_recipes);
	if ($stmt->num_rows > 0) {
		$stmt->fetch();
		$found = true;
		$user_recipes = json_decode($_SESSION['user_recipes']);
		if ($db_user_recipes == "") {
			$db_user_recipes_ex = array();
		}
		else {
			$db_user_recipes_ex = explode("|", $db_user_recipes);
		}
		foreach ($user_recipes as $user_recipe) {
			if (!in_array($user_recipe, $db_user_recipes_ex)) {
				array_push($db_user_recipes_ex, $user_recipe);
			}
		}
	}
	$stmt->close();
	if ($found) {
		$db_user_recipes_cn = "";
		$arr_length = count($db_user_recipes_ex);
		$i = 1;
		foreach ($db_user_recipes_ex as $user_recipe) {
			$db_user_recipes_cn = $db_user_recipes_cn.$user_recipe;
			if ($i < $arr_length) {
				$db_user_recipes_cn = $db_user_recipes_cn."|";
			}
			$i++;
		}
		$stmt = $db_connection->prepare("UPDATE user_recipes SET fav_recipes=? WHERE LOWER(nickname)=LOWER(?);");
		$stmt->bind_param("ss", $db_user_recipes_cn, $_SESSION['boissons_user_nickname']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();
	}
	mysqli_close($db_connection);
?>