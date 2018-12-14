<?php

/**
 * Cette page chargée par AJAX enlève une recette de la liste des recettes favorites de l'utilisateur.
 */
	session_start();
    $elem = $_REQUEST["elem"];
	include("../bdd_connexion.php");
	if ($_SESSION['boissons_user_connected']) {
		$stmt = $db_connection->prepare("SELECT fav_recipes FROM user_recipes WHERE LOWER(nickname)=LOWER(?);");
		$stmt->bind_param("s", $_SESSION['boissons_user_nickname']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($db_user_recipes);
		$stmt->fetch();
		if (strcmp($db_user_recipes, "") == 0) {
			$user_recipes = array();
		}
		else {
			$user_recipes = explode("|", $db_user_recipes);
		}
		$stmt->close();
		$db_user_recipes_cn = "";
		$arr_length = count($user_recipes)-1;
		$i = 1;
		foreach ($user_recipes as $user_recipe) {
			if (strcmp($user_recipe, $elem) != 0 && strcmp($user_recipe, "") != 0) {
				$db_user_recipes_cn = $db_user_recipes_cn.$user_recipe;
				if ($i < $arr_length) {
					$db_user_recipes_cn = $db_user_recipes_cn."|";
				}
			}
			$i++;
		}
		$stmt = $db_connection->prepare("UPDATE user_recipes SET fav_recipes=? WHERE LOWER(nickname)=LOWER(?);");
		$stmt->bind_param("ss", $db_user_recipes_cn, $_SESSION['boissons_user_nickname']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();
	}
	else {
		//$user_recipes = json_decode($_COOKIE['user_recipes'], true);
		$user_recipes = json_decode($_SESSION['user_recipes']);
		$key = array_search($elem, $user_recipes);
		unset($user_recipes[$key]);
		//setcookie('user_recipes', json_encode($user_recipes), time() + 36000);
		$_SESSION['user_recipes'] = json_encode($user_recipes);
	}
	mysqli_close($db_connection);
?>